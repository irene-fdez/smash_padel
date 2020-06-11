$(document).ready(function() {
    table = $('#example').DataTable();

    table.destroy();

    table = $('#example').DataTable({
        "order": [[0, 'desc']],
        "language":{
            "emptyTable": "Por el momento no hay datos disponibles"
        }
    });
});

function comprobar_pareja(){
    
    //si el login del capitan es el mismo que el de la pareja ->> error
    var capitan = document.getElementById("input-capitan").value;
    var jugador2 = document.getElementById("input-jugador2").value;
   
    if(capitan == jugador2){
        document.getElementById("aviso_pareja_igual").click();
        return false;
    }
    else{
        document.add_pareja.submit();
        return true; 
    }
    
}

function comprobar_sets(){
    //se obtienen los valores de los campos
    var set1_p1 = document.getElementById("set1_p1").value;
    var set1_p2 = document.getElementById("set1_p2").value;
    var set2_p1 = document.getElementById("set2_p1").value;
    var set2_p2 = document.getElementById("set2_p2").value;

    if(  (set1_p1 > set1_p2 && set2_p1 > set2_p2) 
        || (set1_p1 < set1_p2 && set2_p1 < set2_p2) ){
        document.getElementById("set3_p1").disabled = true;
        document.getElementById("set3_p2").disabled = true;

    }else{
        document.getElementById("set3_p1").disabled = false;
        document.getElementById("set3_p2").disabled = false;
    }
}

/*
function comprobar_resultados(){
    //se obtienen los valores de los campos
    var set1_p1 = document.getElementById("set1_p1").value;
    var set1_p2 = document.getElementById("set1_p2").value;
    var set2_p1 = document.getElementById("set2_p1").value;
    var set2_p2 = document.getElementById("set2_p2").value;
    var set3_p1 = document.getElementById("set3_p1").value;
    var set3_p2 = document.getElementById("set3_p2").value;

    if( (set1_p1 > 0 || set1_p2 > 0)  && (set2_p1 > 0 || set2_p2 > 0) ){
        if(     (set1_p1 > set1_p2 && set2_p1 < set2_p2)
            ||  (set1_p2 > set1_p1 && set2_p2 < set2_p1)
            &&  (set3_p1 == 0 || set3_p2 == 0)
            ){
                document.getElementById("aviso_set3").click();
                return false;
            }else{
                document.add_resultado.submit();
                return true; 
            }
    }else{
        document.getElementById("aviso_envio").click();
        return false;
    }

}
*/
function ganaset(p1,p2){
    if( (p1>=6 && p1-1>p2) || (p1==7 && p2==6) )         return 1;//gana p1
    else if( (p2>=6 && p2-1>p1) || (p2==7 && p1==6) )    return 2;//gana p2
    else                                                 return 0;//empate 
}
function getResult(array){
    return array[0]+array[1]+array[2]; //suma de sets
}
function comprobar_resultados(){
    //se obtienen los valores de los campos
    var set1_p1 = document.getElementById("set1_p1").value;
    var set1_p2 = document.getElementById("set1_p2").value;
    var set2_p1 = document.getElementById("set2_p1").value;
    var set2_p2 = document.getElementById("set2_p2").value;
    var set3_p1 = document.getElementById("set3_p1").value;
    var set3_p2 = document.getElementById("set3_p2").value;

    resultados=[ [0,0,0],[0,0,0] ];
    //Jugador 1
    resultados[0][0]=ganaset(set1_p1,set1_p2) == 1?1:0;
    resultados[0][1]=ganaset(set2_p1,set2_p2) == 1?1:0;
    resultados[0][2]=ganaset(set3_p1,set3_p2) == 1?1:0;

    //Jugador2
    resultados[1][0]=ganaset(set1_p1,set1_p2) == 2?1:0;
    resultados[1][1]=ganaset(set2_p1,set2_p2) == 2?1:0;
    resultados[1][2]=ganaset(set3_p1,set3_p2) == 2?1:0;

    result1=getResult(resultados[0]);//p1
    result2=getResult(resultados[1]);//p2

    if (result1 == 2 || result2 == 2){ //gana p1 o p2
        document.add_resultado.submit();
        return true; 
    }else if(result1==1&&result2==1){ //empate
        console.log(result1 + "\n" + result2);
        document.getElementById("aviso_set3").click();
        return false;
    }else{//ningun resultado
        document.getElementById("aviso_envio").click();
        return false;
    }

        /*if( (set1_p1 > 0 || set1_p2 > 0)  && (set2_p1 > 0 || set2_p2 > 0) ){
        if( (set1_p1>=6 && set1_p1>set1_p2) || (set1_p2>=6 && set1_p2>set1_p1)){
            if( (set2_p1>=6 && set2_p1>set2_p2) ||(set2_p2>=6 && set2_p2>set2_p1) ){
                    document.add_resultado.submit();
                    return true; 
            }else{
                document.getElementById("aviso_set3").click();
                return false;
            }
        }
        else{
            //No se puede enviar porue no hay ganador
            document.getElementById("aviso_envio").click();
            return false;
        }
    }else{
        document.getElementById("aviso_envio").click();
        return false;
    }*/
    /*
    if( ganaset(set1_p1,set1_p2) == ganaset(set2_p1,set2_p2) == 1 ){ //Gana 1
        document.add_resultado.submit();
        return true; 
    }else if( ganaset(set1_p1,set1_p2) == ganaset(set2_p1,set2_p2) == 2){ //Gana 2
        document.add_resultado.submit();
        return true; 
    }else{


        document.getElementById("aviso_set3").click();
        return false;
    }
*/



/*


        if(   (  (set1_p1 > set1_p2 && set2_p1 < set2_p2)
            ||  (set1_p2 > set1_p1 && set2_p2 < set2_p1) )
            &&  (set3_p1 == 0 && set3_p2 == 0)
            ){
                document.getElementById("aviso_set3").click();
                return false;
            }else{
                if( !( (set1_p1 >= 6 || set1_p2 >= 6) && (set2_p1 >= 6 || set2_p2 >= 6) )
                 || (  (set1_p1 > set1_p2 && set2_p1 < set2_p2) ||  (set1_p2 > set1_p1 && set2_p2 < set2_p1) 
                        && !( (set1_p1 >= 6 || set1_p2 >= 6) && (set2_p1 >= 6 || set2_p2 >= 6) && (set2_p3 >= 6 || set2_p3 >= 6) ))
                  ){
                    document.getElementById("aviso_6").click();
                    return false;
                }
                else{alert('enviar');
                   // document.add_resultado.submit();
                    return true; 
                }
                
            }
    }else{
        document.getElementById("aviso_envio").click();
        return false;
    }*/

}