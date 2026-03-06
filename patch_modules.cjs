const fs = require('fs');

const moduleUpdates = [
    { controller: 'app/Http/Controllers/BusinessProtection/DashboardBusinessProtectionController.php', type_key: 'អាជីវកម្មឯកជន' },
    { controller: 'app/Http/Controllers/Civil/DashboardCivilController.php', type_key: 'រដ្ឋប្បវេណី' },
    { controller: 'app/Http/Controllers/Contract/DashboardContractController.php', type_key: 'កិច្ចសន្យា' },
    { controller: 'app/Http/Controllers/Criminal/DashboardCriminalController.php', type_key: 'ព្រហ្មទណ្ឌ' },
    { controller: 'app/Http/Controllers/FamilyProtection/DashboardFamilyProtectionController.php', type_key: 'Protection Family' },
    { controller: 'app/Http/Controllers/IndividualProtection/DashboardIndividualProtectionController.php', type_key: 'Personal Protection' },
    { controller: 'app/Http/Controllers/Outcourt/DashboardOutcourtController.php', type_key: 'Outcourt' },
    { controller: 'app/Http/Controllers/Protection/DashboardProtectionController.php', type_key: 'Protection' },
    { controller: 'app/Http/Controllers/SOP/DashboardSOPController.php', type_key: 'ស្ដង់ដារអាជីវកម្ម' },
];

for (let mod of moduleUpdates) {
    if (fs.existsSync(mod.controller)) {
        let code = fs.readFileSync(mod.controller, 'utf8');
        // Fix the line: $data = $this->getDashboardData(); -> $data = $this->getDashboardData('KEY');
        if (code.includes('$this->getDashboardData()')) {
            code = code.replace(/\$this->getDashboardData\(\)/, `$this->getDashboardData('${mod.type_key}')`);
            fs.writeFileSync(mod.controller, code, 'utf8');
            console.log('Fixed ' + mod.controller);
        }
    }
}
