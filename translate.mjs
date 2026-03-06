import fs from 'fs';
import path from 'path';

// Google Translate API endpoint
async function translateText(text) {
    if (!text || text.trim() === '') return text;
    try {
        const response = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=km&tl=en&dt=t&q=${encodeURIComponent(text)}`);
        const json = await response.json();
        const translated = json[0].map(item => item[0]).join('');
        // Capitalize the first letter of each word to make it look like a label/title
        return translated.replace(/\b\w/g, c => c.toUpperCase());
    } catch (error) {
        console.error(`Error translating "${text}":`, error);
        return text; // Return original if error
    }
}

// Recursively get all .blade.php files
function getBladeFiles(dir, fileList = []) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            getBladeFiles(filePath, fileList);
        } else if (filePath.endsWith('.blade.php')) {
            fileList.push(filePath);
        }
    }
    return fileList;
}

// Main processing function
async function processProject() {
    const viewsDir = path.join(process.cwd(), 'resources', 'views');
    const bladeFiles = getBladeFiles(viewsDir);
    
    // Regex matches contiguous Khmer blocks separated by spaces
    // Include the zero-width joined \u200B which might be used in Khmer text
    const khmerRegex = /[\u1780-\u17FF\u200B]+(?:\s+[\u1780-\u17FF\u200B]+)*/g;

    const uniquePhrases = new Set();
    const filesWithMatches = [];

    console.log(`Scanning ${bladeFiles.length} blade files for Khmer text...`);

    // 1. Scan and collect unique phrases
    for (const file of bladeFiles) {
        const content = fs.readFileSync(file, 'utf8');
        let hasMatch = false;
        
        // Find all matches in this file
        let match;
        while ((match = khmerRegex.exec(content)) !== null) {
            uniquePhrases.add(match[0]);
            hasMatch = true;
        }

        if (hasMatch) {
            filesWithMatches.push({ file, content });
        }
    }

    console.log(`Found ${uniquePhrases.size} unique Khmer phrases across ${filesWithMatches.length} files.`);
    console.log('Starting translation... This may take a few minutes.');

    // 2. Translate unique phrases
    const translationMap = new Map();
    let count = 0;
    for (const phrase of uniquePhrases) {
        count++;
        // Print progress every 50 translations
        if (count % 50 === 0) console.log(`Translated ${count}/${uniquePhrases.size}...`);
        
        const translated = await translateText(phrase);
        translationMap.set(phrase, translated);
        
        // Sleep to avoid rate limiting from Google (200ms)
        await new Promise(r => setTimeout(r, 200));
    }

    console.log('Translation complete. Now updating files...');

    // 3. Replace phrases in files and save
    let updatedFiles = 0;
    for (const fileObj of filesWithMatches) {
        let newContent = fileObj.content.replace(khmerRegex, (match) => {
            return translationMap.get(match) || match;
        });

        if (newContent !== fileObj.content) {
            fs.writeFileSync(fileObj.file, newContent, 'utf8');
            updatedFiles++;
        }
    }

    console.log(`Successfully updated ${updatedFiles} files!`);
}

processProject().catch(console.error);
