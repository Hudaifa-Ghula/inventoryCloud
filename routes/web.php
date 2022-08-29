<?php
use App\Models\User;
use App\Models\product;
use App\Models\buy;
use App\Models\sell;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SocialController;
use App\Models\company;
use App\Models\inventory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/','company@store');
Route::get('profile', function () {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();
    return view('profile.show',['admin'=>$admin,'company'=>$company,'user'=>$user]);
});

Route::get('/exportBuy',function(){
    $user = Auth::user();
    $fileName = 'purchases_record.csv';
    $buys = DB::table('buys')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Quantity', 'Price', 'Date', 'Status');

        $callback = function() use($buys, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($buys as $buy) {
                $row['ID']  = $buy->id;
                $row['Quantity']    = $buy->qty;
                $row['Price']    = $buy->price;
                $row['Date']  = $buy->created_at;
                $row['Status']  = $buy->status;

                fputcsv($file, array($row['ID'], $row['Quantity'], $row['Price'], $row['Date'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);


});
Route::get('/exportSell',function(){
    $user = Auth::user();
    $fileName = 'sales_record.csv';
    $buys = DB::table('sells')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Quantity', 'Price', 'Date', 'Status');

        $callback = function() use($buys, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($buys as $buy) {
                $row['ID']  = $buy->id;
                $row['Quantity']    = $buy->qty;
                $row['Price']    = $buy->price;
                $row['Date']  = $buy->created_at;
                $row['Status']  = $buy->status;

                fputcsv($file, array($row['ID'], $row['Quantity'], $row['Price'], $row['Date'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);


});
Route::post('/sellPro', function(){

    $user = Auth::user();
    $company = company::find($user->cid);
    $company->sold = $company->sold + request('p')*request('qty');
    $company->save();

    $inventory = inventory::find(request('id'));
    $inventory->qty -= request('qty');
    $inventory->save();
    $sell = new sell;
    $sell->img = $inventory->img;
    $sell->qty= request('qty');
    $sell->status= "complete";
    $sell->cid = $user->cid;
    $sell->price = request('p')*request('qty');
    $sell->save();

//dump(request()->all());
    return redirect('/inventory');

});
Route::post('/proBuy', function(){
    //dump(request()->all());
    $user = Auth::user();
    $company = company::find($user->cid);
    $product = product::find(request('id'));
    $company->bought = $company->bought + request('price')*request('qty');
    $company->save();


    $buy = new buy;
    $buy->img = $product->img;
    $buy->qty= request('qty');
    $buy->code = $product->code;
    $buy->status= "complete";
    $buy->cid = $user->cid;
    $buy->price = request('price')*request('qty');
    $buy->save();

    $inventory = DB::table('inventories')->where('cid', $user->cid)->where('code', $product->code)->first();
    if($inventory == NULL){
        $inventory = new inventory;
        $inventory->code = $product->code;
        $inventory->dsc = $product->dsc;
        $inventory->img = $product->img;
        $inventory->uom = $product->uom;
        $inventory->cid = $user->cid;
        $inventory->cost = request('price');
        $inventory->qty = request('qty');
        $inventory->save();}
    else{
        $inventory = inventory::find($inventory->id);
        $inventory->qty += request('qty');
        $inventory->save();
    }

    return redirect('/products');

});

Route::post('/renu', function () {
    //dump(request()->all());
    $user = Auth::user();
    request()->validate([
        'months' => 'required|max:255',
    ]);
    $company = company::find($user->cid);
    $m = request('months');
    $Date1 = $company->expiry;
$date = new DateTime($Date1);
while($m!=0){
$date->modify('+1 month');
$m--;}

$Date2 = $date->format('Y-m-d');
    $company->plan = request('planName');

    $company->expiry = $Date2;

    $company->save();
    return redirect('/settings');

});

Route::post('/newCom', function () {
    //dump(request()->all());
    $user = Auth::user();
    request()->validate([
        'name' => 'required|unique:companies|max:255',
    ]);
    $company = company::find($user->cid);
    $company->name = request('name');
    $company->plan = request('planName');
    $company->expiry = date('Y-m-d', strtotime('+1 month'));
    $company->save();
    return redirect('/');

});

Route::post('/newMem', function () {
    //dump(request()->all());
    request()->validate([
        'email' => 'required|unique:users',
        'name' => 'required',
        'password' => 'required',
    ]);
    $user = Auth::user();
    $newU = new User;

    $newU->name = request('name');
    $newU->email = request('email');
    $newU->password = bcrypt(request('password'));
    $newU->cid = $user->cid;

    $newU->save();
    return redirect('/');

});
    /*
Route::post('/dashboard', function () {
    dump(request()->all());
$user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $company->name = request('name');
    $company->save();
    return redirect('/');
    });
*/

Route::get('/', function (User $user) {
    $user = Auth::user();

    $members = DB::table('users')->where('cid', $user['cid'])->get()->toArray();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    if(!isset($company)){
        $company = new company;
        $company->admin_id = $user->id;
        $company->save();
        $user->cid = $company->id;
        $user->save();

    }
    $admin = DB::table('users')->where('id', $company->admin_id)->get();

    return view('dash',['admin'=>$admin,'company'=>$company, 'members'=>$members, 'user'=>$user]);
})->middleware('auth');



Route::get('/inventory', function (User $user) {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $inventory = DB::table('inventories')->where('cid', $user['cid'])->get();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();
    return view('inventory',['admin'=>$admin,'company'=>$company, 'user'=>$user, 'inventory'=>$inventory]);
})->middleware('auth');


Route::get('/dashboard', function (User $user) {
    $user = Auth::user();

    $members = DB::table('users')->where('cid', $user['cid'])->get()->toArray();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    if(!isset($company)){
        $company = new company;
        $company->admin_id = $user->id;
        $company->save();
    }
    $user->cid = $company->id;
    $user->save();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();

    return view('dash',['admin'=>$admin,'company'=>$company, 'members'=>$members, 'user'=>$user]);
})->middleware('auth');


Route::get('/test', function () {
    return view('signin');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/deeznuts', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/products/{id}', function ($id) {
    $user = Auth::user();
        $products = product::all();
        $buys = DB::table('buys')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();
        return view('products', [
            'products' => $products, 'buys'=>$buys, 'id'=>$id
        ]);
    })->middleware('auth');

Route::get('/products', function () {
$user = Auth::user();
$id =0;
    $products = product::all();
    $buys = DB::table('buys')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();
    return view('products', [
        'products' => $products, 'buys'=>$buys , 'id'=>$id
    ]);
})->middleware('auth');

Route::get('/settings', function (User $user) {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();
    return view('setting',['admin'=>$admin,'company'=>$company,'user'=>$user]);
})->middleware('auth');

Route::get('/buy', function (User $user) {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();
    $buy = DB::table('buys')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();
    return view('buy',['buy'=>$buy, 'admin'=>$admin,'company'=>$company,'user'=>$user]);
})->middleware('auth');

Route::get('/sell', function (User $user) {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user['cid'])->first();
    $admin = DB::table('users')->where('id', $company->admin_id)->get();
    $sell = DB::table('sells')->where('cid', $user['cid'])->orderBy('created_at', 'DESC')->get();
    return view('sell',['sell'=>$sell, 'admin'=>$admin,'company'=>$company,'user'=>$user]);
});


Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);

Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);
