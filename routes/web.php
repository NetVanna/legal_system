<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BusinessProtectionCaseController;
use App\Http\Controllers\Admin\CaseCodeController;
use App\Http\Controllers\Admin\CasesController;
use App\Http\Controllers\Admin\ChaptersController;
use App\Http\Controllers\Admin\CivilCaseController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\ContractCaseController;
use App\Http\Controllers\Admin\CriminalCaseController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\FamilyProtectionCaseController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ManageBenefitCasesController;
use App\Http\Controllers\Admin\OtherCasesController;
use App\Http\Controllers\Admin\OtherController;
use App\Http\Controllers\Admin\OutcourtCaseController;
use App\Http\Controllers\Admin\PersonalProtectionController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProtectionCaseController;
use App\Http\Controllers\Admin\SOPCaseController;
use App\Http\Controllers\Admin\SubChaptersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BusinessProtection\CasesBusinessProtectionController;
use App\Http\Controllers\BusinessProtection\DashboardBusinessProtectionController;
use App\Http\Controllers\Civil\CasesCivilController;
use App\Http\Controllers\Civil\DashboardCivilController;
use App\Http\Controllers\Contract\CasesContractController;
use App\Http\Controllers\Contract\DashboardContractController;
use App\Http\Controllers\Criminal\CasesController as CriminalCasesController;
use App\Http\Controllers\Criminal\CasesCriminalController;
use App\Http\Controllers\Criminal\DashboardCriminalController;
use App\Http\Controllers\FamilyProtection\CasesFamilyProtectionController;
use App\Http\Controllers\FamilyProtection\DashboardFamilyProtectionController;
use App\Http\Controllers\IndividualProtection\CasesIndividualProtectionController;
use App\Http\Controllers\IndividualProtection\DashboardIndividualProtectionController;
use App\Http\Controllers\Outcourt\CasesOutcourtController;
use App\Http\Controllers\Outcourt\DashboardOutcourtController;
use App\Http\Controllers\Protection\CasesProtectionController;
use App\Http\Controllers\Protection\DashboardProtectionController;
use App\Http\Controllers\SOP\CasesSOPController;
use App\Http\Controllers\SOP\DashboardSOPController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/** for side bar menu active */
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}
/** for side bar menu show */
function set_show($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'show' : '';
    }
    return Request::path() == $route ? 'show' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('dashboard.home');
    });
});


Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('logout/page', 'logoutPage')->name('logout/page');
    });
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    // ======================== Admin Role ========================== //
    Route::middleware(['auth', 'role:admin'])->group(function () {

        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('admin.home');
        });

        // -------------------------- Profile ---------------------- //
        Route::controller(AccountController::class)->group(function () {
            Route::get('page/account/{user_id}', 'profileDetail')->name('account.profile');
        });

        // -------------------------- Position Department ---------------------- //
        Route::prefix('positions')->name('positions.')->controller(PositionController::class)->group(function () {
            Route::get('list', 'index')->name('index');      // chapter_department.index
            Route::post('list', 'store')->name('store');     // chapter_department.store
            // Route::get('list/{id}', 'show')->name('show');   // chapter_department.show
            Route::put('list/{id}', 'update')->name('update'); // chapter_department.update
            Route::delete('list/{id}', 'destroy')->name('destroy'); // chapter_department.destroy
        });


        // -------------------------- Chapter Department ---------------------- //
        Route::prefix('chapter_department')->name('chapter_department.')->controller(ChaptersController::class)->group(function () {
            Route::get('list', 'index')->name('index');      // chapter_department.index
            Route::post('list', 'store')->name('store');     // chapter_department.store
            // Route::get('list/{id}', 'show')->name('show');   // chapter_department.show
            Route::put('list/{id}', 'update')->name('update'); // chapter_department.update
            Route::delete('list/{id}', 'destroy')->name('destroy'); // chapter_department.destroy
        });
        // -------------------------- SubChapter Department ---------------------- //
        Route::prefix('subchapter_department')->name('subchapter_department.')->controller(SubChaptersController::class)->group(function () {
            Route::get('list', 'index')->name('index');      // chapter_department.index
            Route::post('list', 'store')->name('store');     // chapter_department.store
            // Route::get('list/{id}', 'show')->name('show');   // chapter_department.show
            Route::put('list/{id}', 'update')->name('update'); // chapter_department.update
            Route::delete('list/{id}', 'destroy')->name('destroy'); // chapter_department.destroy
        });

        // -------------------------- HR Managements ---------------------- //
        Route::prefix('employee')->name('employee.')->group(function () {

            // ----- Manage Employee CRUD ----- //
            Route::controller(EmployeeController::class)->prefix('manage')->name('manage.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        });

        // -------------------------- Clients ---------------------- //
        Route::prefix('client')->name('client.')->controller(ClientsController::class)->group(function () {
            Route::get('list', 'index')->name('index');      // client.index
            Route::post('list', 'store')->name('store');     // client.store
            // Route::get('list/{id}', 'show')->name('show');   // client.show
            Route::put('list/{id}', 'update')->name('update'); // client.update
            Route::delete('list/{id}', 'destroy')->name('destroy'); // client.destroy
        });

        // -------------------------- Case Code ---------------------- //
        Route::prefix('casecodes')->name('casecodes.')->controller(CaseCodeController::class)->group(function () {
            Route::get('list', 'index')->name('index');      // chapter_department.index
            Route::post('list', 'store')->name('store');     // chapter_department.store
            // Route::get('list/{id}', 'show')->name('show');   // chapter_department.show
            Route::put('list/{id}', 'update')->name('update'); // chapter_department.update
            Route::delete('list/{id}', 'destroy')->name('destroy'); // chapter_department.destroy
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('cases')->name('cases.')->group(function () {
            // Main list
            Route::controller(CasesController::class)->group(function () {
                Route::get('/', 'index')->name('index');
            });
            // Criminal routes
            Route::controller(CriminalCaseController::class)->group(function () {

                Route::get('/criminal', 'index')->name('criminal');
                Route::get('/create/criminal', 'create')->name('create-criminal-case');
                Route::post('/store/criminal', 'store')->name('store-criminal-case');
                Route::get('/criminal/{id}/edit', 'edit')->name('edit-criminal-case');
                Route::put('/criminal/{id}/edit', 'update')->name('update-criminal-case');
                Route::delete('/criminal/{id}/destroy', 'destroy')->name('destroy-criminal-case');
            });
            // Civil routes
            Route::controller(CivilCaseController::class)->group(function () {

                Route::get('/civil', 'index')->name('civil');
                Route::get('/create/civil', 'create')->name('create-civil-case');
                Route::post('/store/civil', 'store')->name('store-civil-case');
                Route::get('/civil/{id}/edit', 'edit')->name('edit-civil-case');
                Route::put('/civil/{id}/edit', 'update')->name('update-civil-case');
                Route::delete('/civil/{id}/destroy', 'destroy')->name('destroy-civil-case');
            });
            // Protection routes
            Route::controller(ProtectionCaseController::class)->group(function () {

                Route::get('/protection', 'index')->name('protection');
                Route::get('/create/protection', 'create')->name('create-protection-case');
                Route::post('/store/protection', 'store')->name('store-protection-case');
                Route::get('/protection/{id}/edit', 'edit')->name('edit-protection-case');
                Route::put('/protection/{id}/edit', 'update')->name('update-protection-case');
                Route::delete('/protection/{id}/destroy', 'destroy')->name('destroy-protection-case');
            });
            // Outcourt routes 
            Route::controller(OutcourtCaseController::class)->group(function () {

                Route::get('/outcourt', 'index')->name('outcourt');
                Route::get('/create/outcourt', 'create')->name('create-outcourt-case');
                Route::post('/store/outcourt', 'store')->name('store-outcourt-case');
                Route::get('/outcourt/{id}/edit', 'edit')->name('edit-outcourt-case');
                Route::put('/outcourt/{id}/edit', 'update')->name('update-outcourt-case');
                Route::delete('/outcourt/{id}/destroy', 'destroy')->name('destroy-outcourt-case');
            });
            // Contract routes  
            Route::controller(ContractCaseController::class)->group(function () {

                Route::get('/contract', 'index')->name('contract');
                Route::get('/create/contract', 'create')->name('create-contract-case');
                Route::post('/store/contract', 'store')->name('store-contract-case');
                Route::get('/contract/{id}/edit', 'edit')->name('edit-contract-case');
                Route::put('/contract/{id}/edit', 'update')->name('update-contract-case');
                Route::delete('/contract/{id}/destroy', 'destroy')->name('destroy-contract-case');
            });
            // SOP routes  
            Route::controller(SOPCaseController::class)->group(function () {

                Route::get('/sop', 'index')->name('sop');
                Route::get('/create/sop', 'create')->name('create-sop-case');
                Route::post('/store/sop', 'store')->name('store-sop-case');
                Route::get('/sop/{id}/edit', 'edit')->name('edit-sop-case');
                Route::put('/sop/{id}/edit', 'update')->name('update-sop-case');
                Route::delete('/sop/{id}/destroy', 'destroy')->name('destroy-sop-case');
            });
            // Business Protection routes  
            Route::controller(BusinessProtectionCaseController::class)->group(function () {

                Route::get('/businessprotection', 'index')->name('businessprotection');
                Route::get('/create/businessprotection', 'create')->name('create-businessprotection-case');
                Route::post('/store/businessprotection', 'store')->name('store-businessprotection-case');
                Route::get('/businessprotection/{id}/edit', 'edit')->name('edit-businessprotection-case');
                Route::put('/businessprotection/{id}/edit', 'update')->name('update-businessprotection-case');
                Route::delete('/businessprotection/{id}/destroy', 'destroy')->name('destroy-businessprotection-case');
            });
            // Family Protection routes 
            Route::controller(FamilyProtectionCaseController::class)->group(function () {

                Route::get('/familyprotection', 'index')->name('familyprotection');
                Route::get('/create/familyprotection', 'create')->name('create-familyprotection-case');
                Route::post('/store/familyprotection', 'store')->name('store-familyprotection-case');
                Route::get('/familyprotection/{id}/edit', 'edit')->name('edit-familyprotection-case');
                Route::put('/familyprotection/{id}/edit', 'update')->name('update-familyprotection-case');
                Route::delete('/familyprotection/{id}/destroy', 'destroy')->name('destroy-familyprotection-case');
            });
            // Personal Protection routes  
            Route::controller(PersonalProtectionController::class)->group(function () {

                Route::get('/personalprotection', 'index')->name('personalprotection');
                Route::get('/create/personalprotection', 'create')->name('create-personalprotection-case');
                Route::post('/store/personalprotection', 'store')->name('store-personalprotection-case');
                Route::get('/personalprotection/{id}/edit', 'edit')->name('edit-personalprotection-case');
                Route::put('/personalprotection/{id}/edit', 'update')->name('update-personalprotection-case');
                Route::delete('/personalprotection/{id}/destroy', 'destroy')->name('destroy-personalprotection-case');
            });
            // Other Cases routes  
            Route::controller(OtherCasesController::class)->group(function () {

                Route::get('/othercase', 'index')->name('othercase');
                Route::get('/create/othercase', 'create')->name('create-othercase-case');
                Route::post('/store/othercase', 'store')->name('store-othercase-case');
                Route::get('/othercase/{id}/edit', 'edit')->name('edit-othercase-case');
                Route::put('/othercase/{id}/edit', 'update')->name('update-othercase-case');
                Route::delete('/othercase/{id}/destroy', 'destroy')->name('destroy-othercase-case');
            });
        });

        // -------------------------- Manage Benefit Cases ---------------------- //
        Route::prefix('manage')->name('manage.')->group(function () {
            // Benefit Cases Route
            Route::prefix('benefit')->name('benefit.')->controller(ManageBenefitCasesController::class)->group(function () {
                Route::get('/case', 'index')->name('case.list');
                Route::get('/case/create', 'create')->name('create.case.list');
                Route::post('/case/store', 'store')->name('store.case');
                Route::get('/case/{id}/details', 'getCaseDetails')->name('case.details');
                Route::get('/case/{id}/edit', 'edit')->name('edit.case');
                Route::put('/case/{id}', 'update')->name('update.case');
                Route::delete('/case/{id}', 'destroy')->name('delete.case'); // New route
            });
        });

        // -------------------------- Other Settings ---------------------- //
        Route::prefix('others')->name('others.')->controller(OtherController::class)->group(function () {
            Route::get('cost', 'listCost')->name('cost.list');
            Route::post('cost', 'costStore')->name('cost.store');
            Route::put('cost/{id}', 'costUpdate')->name('cost.update');
            Route::delete('cost/{id}', 'costDestroy')->name('cost.destroy');
        });
    });
    // ======================== Criminal Role ========================== //
    Route::middleware(['auth', 'role:criminal'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardCriminalController::class)->group(function () {
            Route::get('/criminal/home', 'index')->name('criminal.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('criminal-cases')->name('criminal-cases.')->group(function () {
            
            // Criminal routes
            Route::controller(CasesCriminalController::class)->group(function () {
                Route::get('/criminal', 'index')->name('criminal');
                Route::get('/create/criminal', 'create')->name('create-criminal-case');
                Route::post('/store/criminal', 'store')->name('store-criminal-case');
                Route::get('/criminal/{id}/edit', 'edit')->name('edit-criminal-case');
                Route::put('/criminal/{id}/edit', 'update')->name('update-criminal-case');
                Route::delete('/criminal/{id}/destroy', 'destroy')->name('destroy-criminal-case');
            });
        });
    });
    // ======================== Civil Role ========================== //
    Route::middleware(['auth', 'role:civil'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardCivilController::class)->group(function () {
            Route::get('/civil/home', 'index')->name('civil.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('civil-cases')->name('civil-cases.')->group(function () {
            
            // civil routes
            Route::controller(CasesCivilController::class)->group(function () {
                Route::get('/civil', 'index')->name('civil');
                Route::get('/create/civil', 'create')->name('create-civil-case');
                Route::post('/store/civil', 'store')->name('store-civil-case');
                Route::get('/civil/{id}/edit', 'edit')->name('edit-civil-case');
                Route::put('/civil/{id}/edit', 'update')->name('update-civil-case');
                Route::delete('/civil/{id}/destroy', 'destroy')->name('destroy-civil-case');
            });
        });
    });
    // ======================== Protection Role ========================== //
    Route::middleware(['auth', 'role:protection'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardProtectionController::class)->group(function () {
            Route::get('/protection/home', 'index')->name('protection.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('protection-cases')->name('protection-cases.')->group(function () {
            
            // protection routes
            Route::controller(CasesProtectionController::class)->group(function () {
                Route::get('/protection', 'index')->name('protection');
                Route::get('/create/protection', 'create')->name('create-protection-case');
                Route::post('/store/protection', 'store')->name('store-protection-case');
                Route::get('/protection/{id}/edit', 'edit')->name('edit-protection-case');
                Route::put('/protection/{id}/edit', 'update')->name('update-protection-case');
                Route::delete('/protection/{id}/destroy', 'destroy')->name('destroy-protection-case');
            });
        });
    });
    // ======================== Outcourt Role ========================== // 
    Route::middleware(['auth', 'role:outcourt'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardOutcourtController::class)->group(function () {
            Route::get('/outcourt/home', 'index')->name('outcourt.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('outcourt-cases')->name('outcourt-cases.')->group(function () {
            
            // outcourt routes
            Route::controller(CasesOutcourtController::class)->group(function () {
                Route::get('/outcourt', 'index')->name('outcourt');
                Route::get('/create/outcourt', 'create')->name('create-outcourt-case');
                Route::post('/store/outcourt', 'store')->name('store-outcourt-case');
                Route::get('/outcourt/{id}/edit', 'edit')->name('edit-outcourt-case');
                Route::put('/outcourt/{id}/edit', 'update')->name('update-outcourt-case');
                Route::delete('/outcourt/{id}/destroy', 'destroy')->name('destroy-outcourt-case');
            });
        });
    });
    // ======================== Contract Role ========================== // 
    Route::middleware(['auth', 'role:contract'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardContractController::class)->group(function () {
            Route::get('/contract/home', 'index')->name('contract.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('contract-cases')->name('contract-cases.')->group(function () {
            
            // contract routes
            Route::controller(CasesContractController::class)->group(function () {
                Route::get('/contract', 'index')->name('contract');
                Route::get('/create/contract', 'create')->name('create-contract-case');
                Route::post('/store/contract', 'store')->name('store-contract-case');
                Route::get('/contract/{id}/edit', 'edit')->name('edit-contract-case');
                Route::put('/contract/{id}/edit', 'update')->name('update-contract-case');
                Route::delete('/contract/{id}/destroy', 'destroy')->name('destroy-contract-case');
            });
        });
    });

    // ======================== SOP Role ========================== // 
    Route::middleware(['auth', 'role:sop'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardSOPController::class)->group(function () {
            Route::get('/sop/home', 'index')->name('sop.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('sop-cases')->name('sop-cases.')->group(function () {
            
            // sop routes
            Route::controller(CasesSOPController::class)->group(function () {
                Route::get('/sop', 'index')->name('sop');
                Route::get('/create/sop', 'create')->name('create-sop-case');
                Route::post('/store/sop', 'store')->name('store-sop-case');
                Route::get('/sop/{id}/edit', 'edit')->name('edit-sop-case');
                Route::put('/sop/{id}/edit', 'update')->name('update-sop-case');
                Route::delete('/sop/{id}/destroy', 'destroy')->name('destroy-sop-case');
            });
        });
    });
    // ======================== Protection Business Role ========================== // 
    Route::middleware(['auth', 'role:protectbusiness'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardBusinessProtectionController::class)->group(function () {
            Route::get('/businessprotection/home', 'index')->name('businessprotection.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('businessprotection-cases')->name('businessprotection-cases.')->group(function () {
            
            // businessprotection routes
            Route::controller(CasesBusinessProtectionController::class)->group(function () {
                Route::get('/businessprotection', 'index')->name('businessprotection');
                Route::get('/create/businessprotection', 'create')->name('create-businessprotection-case');
                Route::post('/store/businessprotection', 'store')->name('store-businessprotection-case');
                Route::get('/businessprotection/{id}/edit', 'edit')->name('edit-businessprotection-case');
                Route::put('/businessprotection/{id}/edit', 'update')->name('update-businessprotection-case');
                Route::delete('/businessprotection/{id}/destroy', 'destroy')->name('destroy-businessprotection-case');
            });
        });
    });
    // ======================== Protection Family Role ========================== // 
    Route::middleware(['auth', 'role:protectfamily'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardFamilyProtectionController::class)->group(function () {
            Route::get('/familyprotection/home', 'index')->name('familyprotection.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('familyprotection-cases')->name('familyprotection-cases.')->group(function () {
            
            // familyprotection routes
            Route::controller(CasesFamilyProtectionController::class)->group(function () {
                Route::get('/familyprotection', 'index')->name('familyprotection');
                Route::get('/create/familyprotection', 'create')->name('create-familyprotection-case');
                Route::post('/store/familyprotection', 'store')->name('store-familyprotection-case');
                Route::get('/familyprotection/{id}/edit', 'edit')->name('edit-familyprotection-case');
                Route::put('/familyprotection/{id}/edit', 'update')->name('update-familyprotection-case');
                Route::delete('/familyprotection/{id}/destroy', 'destroy')->name('destroy-familyprotection-case');
            });
        });
    });
    // ======================== Protection Individual Role ========================== // 
    Route::middleware(['auth', 'role:protectindividual'])->group(function () {
        // -------------------------- Main Dashboard ---------------------- //
        Route::controller(DashboardIndividualProtectionController::class)->group(function () {
            Route::get('/individualprotection/home', 'index')->name('individualprotection.home');
        });
        // -------------------------- Cases  ---------------------- //
        Route::prefix('individualprotection-cases')->name('individualprotection-cases.')->group(function () {
            
            // individualprotection routes
            Route::controller(CasesIndividualProtectionController::class)->group(function () {
                Route::get('/individualprotection', 'index')->name('individualprotection');
                Route::get('/create/individualprotection', 'create')->name('create-individualprotection-case');
                Route::post('/store/individualprotection', 'store')->name('store-individualprotection-case');
                Route::get('/individualprotection/{id}/edit', 'edit')->name('edit-individualprotection-case');
                Route::put('/individualprotection/{id}/edit', 'update')->name('update-individualprotection-case');
                Route::delete('/individualprotection/{id}/destroy', 'destroy')->name('destroy-individualprotection-case');
            });
        });
    });
});
