<?php
    require_once "../models/RiegoModel.php";


    $option = $_REQUEST['op'];
    $objRiego = new RiegoModel();

    if($option == "listregistros"){
        $arrResponse = array('status' => false, 'data' => "");
        $arrRiego = $objRiego->getRiego();
        
        //if(!empty($arrRiego)){
         //   for ($i=0; $i < count($arrRiego) ; $i++){
           //     $idriego = $arrRiego[$i]->$idriego;
             //   $options = '<a href="'.BASE_URL.'views/riego/modificar-riego.php?p='.$idriego.'" class="btn btn-outline-info btn-sm" title="Modificar riego"> <i class="fa-regular fa-pen-to-square"></i></a>
               //             <button class="btn btn-outline-danger btn-sm" title="Eliminar riego" onclick="fntDelRiego('.$idriego.')"><i class="fa-regular fa-trash-can"></i></button>'; 

        //        $arrRiego[$i]->options = $options;
        //    }

            $arrResponse['status'] = true;
            $arrResponse['data'] = $arrRiego;
        //}
        echo json_encode($arrResponse);  
        die();
    }

    if($option == "registro"){
        echo "Registrar Riego";
    }

    if($option == "verregistro"){
        echo "Ver un registro de Riego";
    }

    if($option == "actualizar"){
        echo "Actualizar un registro de Riego";
    }
    
    if($option == "eliminar"){
        echo "Eliminar un registro de Riego";
    }
    
    

    die();




?>