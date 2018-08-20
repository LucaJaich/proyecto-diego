<?php
class Fechas {


  public function edad_gestacional_fum($dateFUM) {
    $dateNow = new DateTime('now');
    $dateFUM = new DateTime($dateFUM);

    $numberdateNow = (int)$dateNow->format('U');
    $numberdateFUM = (int)$dateFUM->format('U');
    $dateEdadGestacional = (((($numberdateNow - $numberdateFUM)/60)/60)/24)/7;
    $parte_int_a=(int)$dateEdadGestacional;
    $parte_dec_a=(((($numberdateNow - $numberdateFUM)/60)/60)/24)%7;

    $EdadGestacionalxFUM = "";
    $EdadGestacionalxFUM = sprintf("%u.%u", $parte_int_a,$parte_dec_a);
    return $EdadGestacionalxFUM;
  }

  public function edad_gestacional_eco($dateECO, $numberEGxECO) {

    $dateNow = new DateTime('now');
    $dateECO = new DateTime($dateECO);
    //$numberEGxECO = 12.5;

    $numberdateNow = (int)$dateNow->format('U');
    $numberdateECO = (int)$dateECO->format('U');

    //Saco la cuenta de cuantos segundos pasaron desde la ecografia hasta ahora
    $numberCuantosSegungosPasaronDesdeLaECO = $numberdateNow - $numberdateECO;

    //Convierto la edad gestacional de la ecografia a segundos para poder sumarla y asi ganar precision
    $numberEGxECOenSegundos = (((($numberEGxECO*60))*60)*24)*7;

    //Le sumo los segundos que pasaron a la EG de la ecografia
    $numerdateECOmasEGEco = $numberCuantosSegungosPasaronDesdeLaECO + $numberEGxECOenSegundos;

    //Lo convierto a semanas
    //Aca obtengo el numero en semanas
    $numberEdadGestacional = (((($numerdateECOmasEGEco)/60)/60)/24)/7;
    $parte_int_a=(int)$numberEdadGestacional;
    //Acá obtengo el numero en dias
    $parte_dec_a=(((($numerdateECOmasEGEco)/60)/60)/24)%7;

    $EdadGestacionalxECO = "";
    //Uno los dos numeros el entero y el decimal
    $EdadGestacionalxECO = sprintf("%u.%u", $parte_int_a,$parte_dec_a);
    return $EdadGestacionalxECO;
  }


  public function convertir_fecha_hora($fecha, $tipo = "solo_fecha") {
    if ($tipo == "solo_fecha") {
      $fecha_conv = date('d-m-Y', strtotime($fecha));
      return $fecha_conv;
    }
    if ($tipo == "fecha_hora") {
      $fecha_conv = date('d-m-Y H:i', strtotime($fecha));
      return $fecha_conv;
    }
  }
  public function hace($fecha, $tipo = "") {

    $fecha1=date_create();
    date_timestamp_get($fecha1);
    $fecha2=date_create($fecha);
    $diff=date_diff($fecha1,$fecha2);
    $anos = $diff->format("%y");
    $meses = $diff->format("%m");
    $dias = $diff->format("%a");
    $horas = $diff->format("%h");
    $minutos = $diff->format("%i");
    if ($anos <1) {
      if ($meses <1) {
        if ($dias <1) {
          if ($horas <1) {
            if ($minutos <1) {
              $diff =  "< de 1min";
            } elseif ($minutos == 1) {
              $diff =  "1min";
            } else {
              $diff =  $minutos . " min";
            }
          } elseif ($horas == 1) {
            $diff =  "1h, " . $minutos . "min";
          } else {
            $diff =  $horas . "hs, " . $minutos . "min";
          }
        } elseif ($dias == 1) {
          $diff =  "1 dia";
        } else {
          $diff =  $dias . " dias";
        }
      } elseif ($meses == 1) {
        $diff =  "1 mes";
      } else {
        $diff =  $meses . " meses";
      }
    } elseif ($anos == 1) {
      $diff =  "1 año";
    } else {
      $diff =  $anos . " años";
    }
    return $diff;

  }


  public function edad($fdn) {
    if(!empty($fdn)) {
      $fecha_nacimiento = new DateTime($fdn);
      $hoy   = new DateTime('today');
      $edad = $fecha_nacimiento->diff($hoy)->y;
      echo $edad;
    } else {
      echo "error";
    }
  }


  public function edad_larga($fdn) {
    if(!empty($fdn)) {
      $dob = strtotime($fdn);
      $current_time = time();
      $age_years = date('Y',$current_time) - date('Y',$dob);
      $age_months = date('m',$current_time) - date('m',$dob);
      $age_days = date('d',$current_time) - date('d',$dob);

      if ($age_days<0) {
        $days_in_month = date('t',$current_time);
        $age_months--;
        $age_days= $days_in_month+$age_days;
      }
      if ($age_months<0) {
        $age_years--;
        $age_months = 12+$age_months;
      }
      echo $age_years . " años y " . $age_months . " meses";
    } else {
      echo "error";
    }
  }



}
?>
