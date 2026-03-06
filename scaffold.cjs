const fs = require('fs');
const path = require('path');

// 1. Extract the dashboard component from Admin home.blade.php
const adminViewPath = 'resources/views/pages/admin/dashboard/home.blade.php';
let content = fs.readFileSync(adminViewPath, 'utf8');

const startMatch = content.indexOf('            <!-- Key Metrics Cards -->');
const endMatch = content.lastIndexOf('</script>') + 9;

if (startMatch !== -1 && endMatch !== -1) {
    const componentContent = content.substring(startMatch, endMatch);
    fs.writeFileSync('resources/views/components/dashboard-stats.blade.php', componentContent, 'utf8');

    // Replace the extracted part with include directive in Admin home
    const newAdminContent = content.substring(0, startMatch) + "            @include('components.dashboard-stats')\n" + content.substring(endMatch);
    fs.writeFileSync(adminViewPath, newAdminContent, 'utf8');
    console.log('Component extracted and admin view updated!');
} else {
    console.log('Failed to find markers in admin view.');
}

// 2. Setup the mapping of controller namespaces and their module filters
const moduleUpdates = [
    {
        controller: 'app/Http/Controllers/BusinessProtection/DashboardBusinessProtectionController.php',
        view: 'resources/views/pages/business_protection/dashboard/index.blade.php',
        type_key: 'អាជីវកម្មឯកជន' // This might be translated or in Khmer in type_case. We'll use translation fallback or generic
    },
    {
        controller: 'app/Http/Controllers/Civil/DashboardCivilController.php',
        view: 'resources/views/pages/civil/dashboard/index.blade.php',
        type_key: 'រដ្ឋប្បវេណី' // From db seeding, what are the type cases? Let's genericize or leave filtering empty if unknown, or match the exact strings used in system. 
        // Note: The UI has changed from khmer to English, but is the database `case_type` translated? 
        // We will just use placeholders for now, but we can check the cases table in DemoSeeder
    },
    { controller: 'app/Http/Controllers/Contract/DashboardContractController.php', view: 'resources/views/pages/contract/dashboard/index.blade.php', type_key: 'កិច្ចសន្យា' },
    { controller: 'app/Http/Controllers/Criminal/DashboardCriminalController.php', view: 'resources/views/pages/criminal/dashboard/index.blade.php', type_key: 'ព្រហ្មទណ្ឌ' },
    { controller: 'app/Http/Controllers/FamilyProtection/DashboardFamilyProtectionController.php', view: 'resources/views/pages/family_protection/dashboard/index.blade.php', type_key: 'Protection Family' },
    { controller: 'app/Http/Controllers/IndividualProtection/DashboardIndividualProtectionController.php', view: 'resources/views/pages/individual_protection/dashboard/index.blade.php', type_key: 'Personal Protection' },
    { controller: 'app/Http/Controllers/Outcourt/DashboardOutcourtController.php', view: 'resources/views/pages/outcourt/dashboard/index.blade.php', type_key: 'Outcourt' },
    { controller: 'app/Http/Controllers/Protection/DashboardProtectionController.php', view: 'resources/views/pages/protection/dashboard/index.blade.php', type_key: 'Protection' },
    { controller: 'app/Http/Controllers/SOP/DashboardSOPController.php', view: 'resources/views/pages/sop/dashboard/index.blade.php', type_key: 'ស្ដង់ដារអាជីវកម្ម' },
];

function updateController(controllerPath, moduleKey) {
    if (!fs.existsSync(controllerPath)) return;
    let code = fs.readFileSync(controllerPath, 'utf8');

    // Add use \App\Traits\DashboardAnalytics;
    // modify public function index()

    // Quick regex to modify index()
    if (!code.includes('use \\App\\Traits\\DashboardAnalytics;')) {
        code = code.replace('{', '{\n    use \\App\\Traits\\DashboardAnalytics;\n');

        // Find public function index() { return view(...); }
        code = code.replace(/public function index\(\s*\)\s*\{[\s\S]*?return view\((['"])(.*?)\1\);[\s\S]*?\}/,
            `public function index()\n    {\n        $data = $this->getDashboardData();\n        return view('$2', $data);\n    }`);

        fs.writeFileSync(controllerPath, code, 'utf8');
        console.log(`Updated Controller: ${controllerPath}`);
    }
}

function updateView(viewPath) {
    if (!fs.existsSync(viewPath)) return;
    let code = fs.readFileSync(viewPath, 'utf8');

    if (!code.includes("@include('components.dashboard-stats')")) {
        // Find {{-- new content --}} and replace it.
        code = code.replace(/\{\{-- new content --\}\}/, "@include('components.dashboard-stats')");
        fs.writeFileSync(viewPath, code, 'utf8');
        console.log(`Updated View: ${viewPath}`);
    }
}

for (const mod of moduleUpdates) {
    updateController(mod.controller, mod.type_key);
    updateView(mod.view);
}
