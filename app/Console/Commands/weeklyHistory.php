<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\History;
use App\User;
use App\Balance;
use App\Fund;
use Carbon\Carbon;

class weeklyHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update weekly historical data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     private function percent($user){
             if($user->hasRole('30')){
                    $userInitials = $user->funds()->where('type', 'initial')->get();
                    $userInvest = 0;
                    foreach ($userInitials as $initial) {
                      $userInvest += $initial->amount;
                    }
                    $fundInitial = Fund::Where('user_id', null)->where('type', 'initial')->where('period_id', null)->first();
                    $fundInvest = $fundInitial->amount;
                    $percent = $userInvest / $fundInvest;
                    return $percent;
             }
     }


    public function handle()
    {
        //
        $users = User::whereHas('roles', function ($query) {
          $query->where('code', '30');
        })->get();

        $today = Carbon::now();

        foreach($users as $user){
          if($user->histories()->first() !== null && $user->periods()->first() !== null){
            $this->info('Start History Weekly Data For User '. $user->name);

              $initial = $user->histories()->where('type', 'weekly')->get()->last();

              $initialT = Carbon::parse($initial->register);
              $periods = $user->periods()->get();
              $diffD = $initialT->diffInWeeks($today);

              $init = $initialT;

              for($i = 1;$i <= $diffD; $i++){
                $balances = array();
                $init = $init->addWeeks(1);
                $this->info('Weekly: Date '. $init->toFormattedDateString());
                $sum = 0;
                $initstamp = $init->timestamp;
                $percent = $this->percent($user);
                  $count = 0;
                  $balancesP = Balance::Where('balances.type', 'fund')->where('user_id', null)->leftJoin('currencies', 'currencies.id', '=', 'balances.currency_id')->select('balances.*', 'symbol', 'value', 'currencies.type', 'name')->get();
                  foreach($balancesP as $balance){
                    if(empty($balances[$count])){
                      $balances[$count] = new \stdClass();
                      $balances[$count]->amount = $balance->amount  * $percent;
                      $balances[$count]->value = $balance->value;
                      $balances[$count]->symbol = $balance->symbol;
                      $balances[$count]->type = $balance->type;
                      $balances[$count]->name = $balance->name;
                      $balances[$count]->value_btc = 0;
                    }else{
                      foreach ($balances as $bal) {
                        if($bal->symbol == $balance->symbol){
                          $newBals = $bal->amount + ($balance->amount  * $percent);
                          $bal->amount = $newBals;
                        }
                      }
                    }
                      $count += 1;
                  }
                  foreach($balances as $balance){
                      if($balance->amount > 0){
                          $symbol = $balance->symbol;
                        $json = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym='.$symbol.'&tsyms=USD&ts='.$initstamp);
                        $data = json_decode($json);
                        $symbol = $balance->symbol;
                        if(isset($data->Response)){
                          $this->info('Weekly: '. $balance->symbol . ' '. $data->Response);
                          if(strtolower($balance->symbol) == 'origin' || (strtolower($balance->symbol) == 'sdt' || strtolower($balance->symbol) == 'tari')){
                            $balance->value = 1;
                          }else{
                            if(strtolower($symbol) == 'npxs'){
                              $balance->value = 0.001;
                            }else{
                              $json = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym=ETH&tsyms=USD&ts='.$initstamp);
                              $data = json_decode($json);
                              $balance->value = $data->ETH->USD;
                            }
                          }
                        }else{
                          $this->info('Weekly: '. $balance->symbol . ' value: '. $data->$symbol->USD);
                          if(strtolower($symbol) == 'prs'){
                            $json2 = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym=ETH&tsyms=USD&ts='.$initstamp);
                            $data2 = json_decode($json2);
                            $balance->value = $data2->ETH->USD;
                          }else{
                            $balance->value = $data->$symbol->USD;
                          }
                        }
                          $na = $balance->amount * $balance->value;
                          $this->info('Weekly: '. $balance->symbol . ' amount: '. $balance->amount . ' newAmount: ' . $na);
                      }else{
                         $na = 0;
                      }
                      $sum += $na;
                  }
                  $this->info('Weekly: Date '. $init->toFormattedDateString(). ' Total: ' . $sum);
                  $history = new History;
                  $history->register = $init;
                  $history->amount = $sum;
                  $history->type = "weekly";
                  $history->user()->associate($user);
                  $history->save();
              }
            }
          }

          $historical = History::Where('user_id', null)->where('type', 'weekly')->get()->last();
          $attributes = isset($historical->amount) ? true : false;

          if($attributes){
              $this->info('Start History Weekly Data For Fund');
              $initialGT = Carbon::parse($historical->created_at);

              $diffGD = $initialGT->diffInWeeks($today);

              $initG = $initialGT;
              for($i = 1;$i <= $diffGD; $i++){
                $initG = $initG->addWeeks(1);
                $this->info('Weekly: Date '. $initG->toFormattedDateString());
                $sum = 0;
                $initGstamp = $initG->timestamp;
                $balances = Balance::Where('balances.type', 'fund')->where('user_id', null)->leftJoin('currencies', 'currencies.id', '=', 'balances.currency_id')->select('balances.*', 'symbol', 'value', 'currencies.type', 'name')->get();
                  foreach($balances as $balance){
                      if($balance->amount > 0){

                          $symbol = $balance->symbol;

                        $json = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym='.$symbol.'&tsyms=USD&ts='.$initGstamp);
                        $data = json_decode($json);
                        if(isset($data->Response)){
                          $this->info('Weekly: '. $balance->symbol . ' '. $data->Response);
                          if(strtolower($balance->symbol) == 'origin' || (strtolower($balance->symbol) == 'sdt' || strtolower($balance->symbol) == 'tari')){
                            $balance->value = 1;
                          }else{
                            if(strtolower($symbol) == 'npxs'){
                              $balance->value = 0.001;
                            }else{
                              $json = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym=ETH&tsyms=USD&ts='.$initGstamp);
                              $data = json_decode($json);
                              $balance->value = $data->ETH->USD;
                            }
                          }
                        }else{
                          $this->info('Weekly: '. $balance->symbol . ' value: '. $data->$symbol->USD);
                          if(strtolower($symbol) == 'prs'){
                            $json2 = file_get_contents('https://min-api.cryptocompare.com/data/pricehistorical?fsym=ETH&tsyms=USD&ts='.$initGstamp);
                            $data2 = json_decode($json2);
                            $balance->value = $data2->ETH->USD;
                          }else{
                            $balance->value = $data->$symbol->USD;
                          }
                        }

                          $newamount = $balance->amount * $balance->value;
                          $this->info('Weekly: '. $balance->symbol . ' amount: '. $balance->amount . ' newAmount: ' . $newamount);
                      }else{
                         $newamount = 0;
                      }
                      $sum += $newamount;
                  }
                  $this->info('Weekly: Date '. $initG->toFormattedDateString(). ' Total: ' . $sum);
                  $history = new History;
                  $history->register = $initG;
                  $history->amount = $sum;
                  $history->type = "weekly";
                  $history->save();
              }

          }
    }
}
