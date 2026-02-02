<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';


    $HtmlPage='
 <body >	
<div class="container p-3 " style="max-width: 800px;">
 <div class="row" > 
 <div class="col m-3" >
 
<p class="h1 m-3">Procedimientos.</p>

<ul class="list-unstyled m-3">
  <li class="m-1">Procedimientos de terreno:
    <ul>
        <li class="m-1" ><a href="#PT1">PT1 Procedimiento instalacion Sirecor <a/></li>
        <li class="m-1" ><a href="#PT2">PT2 Procedimiento instalacion Sirecor Estanque <a/></li>
        <li class="m-1" ><a href="#PT3">PT3 Procedimiento instalacion Milesight autoEnegizado <a/></li>
        <li class="m-1" ><a href="#PT4">PT4 Procedimiento instalacion Milesight con Caja de energizacion <a/></li>
        <li class="m-1" ><a href="#PT5">PT5 Procedimeinto revision flujometro Milesight autoEnegizado <a/></li>
        <li class="m-1" ><a href="#PT6">PT6 Procedimeinto revision flujometro Milesight con Caja de energizacion<a/></li> 
        <li class="m-1" ><a href="#PT7">PT7 Procedimeinto revision flujometro Sirecor <a/></li>
        <li class="m-1" ><a href="#PT8">PT8 Procedimeinto revision Sirecor Estanque sensores de nivel <a/></li>
        <li class="m-1" ><a href="#PT9">PT9 Procedimeinto cambio de programa sirecor <a/></li>
        <li class="m-1" ><a href="#PT10">PT10 Procedimeinto mantencion sirecor <a/></li>
        <li class="m-1" ><a href="#PT11">PT11 Procedimeinto mantencion sirecor Estanque <a/></li>
        <li class="m-1" ><a href="#PT12">PT12 Procedimeinto mantencion Milesight autoEnegizado (PT13)  <a/></li>
        <li class="m-1" ><a href="#PT13">PT13 Procedimeinto mantencion Milesight con Caja de energizacion   <a/></li>
    </ul>
  </li>

</ul>







</div> </div> 

<div class="row" > 
<div class="col m-3" >

<p class="h2 m-3">1 Metodología de trabajo.</p>

<p class="m-3" style="white-space: pre-line;">El equipo de Desarrollo de ECO3 utiliza Metodologías ágiles para realizar proyectos.
Se utiliza el Scrum como marco de trabajo. Los proyectos son a corto plazo (1 semana)
y estan relacionados a Investigación o mejoras a proyectos existentes.

Con los Sprint de Scrum abarcamos todo lo nuevo, pero cuando las cosas fallan utilizamos
tickets para revisar los problemas que vayan apareciendo en los proyectos existentes.</p>



</div> </div> 
<div class="row" >
 <div class="col m-3" >
 
 <p class="h2 m-3">1.1 Sprints</p>

<p class="m-3" style="white-space: pre-line;">Los Sprints son ciclos cortos de trabajo que culminan en la entrega de un producto funcional.
Los Sprints estan asociados a una historia de usuario, que es una funcionalidad que el
cliente ( Gerencia de ECO3 ) va a disponer luego de terminar el Sprint.

EL SPRINT NO ES UNA LISTA DE TAREAS. Las tareas son creadas en función de la historia de usuario.

Una historia de usuario es una descripción breve, simple y no técnica de una funcionalidad,
escrita desde la perspectiva del usuario final (cliente o usuario) para expresar una necesidad y el valor que aporta.

EJEMPLO: "Como usuario quiero ver la presión en los cuarteles A, B, y C"

Las tareas, son todo lo necesario para que la funcionalidad sea posible.
 EJEMPLO:"1) Instalar sensores de presión en los cuarteles A, B, y C".
        "2) Crear una plataforma de visualización de la presión".

Las tareas de terreno, muchas estan estandarizadas. Mas adelante se muestran los procedimientos para
tareas que estan estandarizadas. Así, todas las tareas estan relacionadas a un procedimiento que determina
como realizarlas.

EJEMPLO:"1) Instalar sensores de presión en los cuarteles A, B, y C. (P123)"
        "P123 procedimiento para instalacion de sensores de presión.
            Herramientas necesarias....
            Tiempo estimado....

            1) Abrir la línea desde ...
            2) Conectar los cables...
            3) Instalar programa..
            4) Testar desde...

Si hay tareas que no tienen un procedimiento y es repetitiva o ya se a ha hecho antes, es necesario crear un procedimiento
para que la tarea este estandarizada.

Ejemplo "(sin procedimiento) Tarea: Ajustar paner solar para que tenga orientación norte y tenga un angulo de 60 grados.
        Luego de hacer la tarea, crear un procedimiento para estandarizar (p124 creado)
        otra tarea de otro Sprint, Tarea: Ajustar paner solar para que tenga orientación norte y tenga un angulo de 60 grados, usar procedimeinto (p124)."


Todas las tareas estan en función una historia, todas las historias estan en función de un product Backlog
todos los backlogs estan en funcion de un Objetivo.

Ejemplo:

Proyecto Iot Minera X,

[     Cliente        ]
[         Gerencia ECO3                                         ]
                                        [               Equipo Desarrollo                      ]
                                        [                   ciclo SCRUM                             ]
(Objetivo)           ( Product Backlog ) ( Historia de usuario )    ( Tareas )   ( Procedimientos ).

Riego Forestacion A   -Control remoto ---> como usuario abrir -> -Fabricar dispositivos --> (P123)
                                          remotamente.         - Instalar dispositivos --> (P124)
                                                              -plataforma crear alerta --> sin procedimiento
                     -riego nocturno

                     -ecoData

                     ... etc
</p>



</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h2 m-3">2 Procedimientos SIMPLES de terreno    </p>

<p class="m-3" style="white-space: pre-line;">Son procedimientos que realizan una función específica.Los procedimientos simples no incluyen otros procedimientos.</p>



</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS2" > 2.1 Procedimiento  Sirecor Crear checklist (PTS2)   </p>

<p class="m-3" style="white-space: pre-line;">
herramientas: Smartphone.

1) Entrar en la página de smartbox: www.smartbox.eco3.cl

2) Iniciar sesión, en la pagina principal elegir la unidad, en la última columna hay un vínculo con la palabra "Ver", a la cual se hara el checklist.
Si la unidad es Sirecor y es nueva, hay que conectarla y ver en unidades indefinidas, buscar por el IMEI de la placa. Luego hacer click en el
vínculo "Ver". Si es Milesight nueva debe hablar con el equipo de desarrollo para que la agrege. Si es Milesight búscala en la tabla Milesight.
(agregar foto del vínculo)

3) Una vez dentro de la unidad hacer click en el vínculo nuevo checklist.
(agregar foto)

4) Ahora hay que completar el checklist con la información de terreno. Los valores esperados están en los campos (agregar foto)
NO UTILICES CARACTERES NO NÚMERICOS COMO LETRAS O SIGNOS. Sólo tienes que agregar el valor del voltaje con punto "." si tiene decimales.
(agregar foto)

5) Checkea todas las funciones que fueron testeadas.
(agregar foto)

6) Agrega tu nombre y un comentario, si tienes algunas observaciones del punto, algo que no se pudo medir o extraño, agrégalo, todo es necesario.
Si no tiene observaciones coloca OK, no puedes dejar el campo vacío.
(agregar foto)

7) Has click para buscar la foto del checklist, la foto debe ojalá aparecer toda la estructura de la válvula y la solenoide, que se vean los chochos y el conduit.
(agregar foto)

8) Has click en upload para subir la foto. Debe aparecer el nombre de la foto en el campo URL_foto.
(agregar foto)

9) Ahora dar subir enviar checklist. Si no tienes errores en los campos dar OK, sino corrígelos. Espera unos segundos debe aperecer un mensaje con los datos enviados.

10) Revisa en smartbox que el checklist se haya creado correctamente. Abre el vínculo "Ver" en la página de inicio y asegúrate que se haya subido el checklist.
(agregar foto)

11) Si tienes problemas contacta con el equipo de desarrollo, guarda toda la información, envía la foto con los datos por el grupo de IOT de Teams para que sea agregado mas tarde.

</p>
</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS3" >2.2Procedimiento  Sirecor mantención panel (PTS3)  </p>
<p class="m-3" style="white-space: pre-line;">
herramientas:
- pano para limpiar panel.
- liquido limpieza panel.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- smartphone.
- llave inglesa para apretar tuerca.
-tester

1) limpiar panel con el liquido, tiene que quedar reluciente.

2) con aplicacion de brújula, apuntar el panel al norte. ajustar a -30 grados.
(foto)

3) desmontar los cable del panel y medir voltaje a circuito abierto. a todo sol debe medir 19v al menos. mover el cable para descartar malas conexiones.
(foto)

4) si los terminales estan oxidadoes o no tiene terminales, cambiar terminales.

</p>


</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS4" >2.3 Procedimiento limpieza valvula solenoide (PTS4)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave para tuerca.
- destornillador de cruz.
- pano para limpar valvula.
- solenoide de repuesto.
- valvula de repuesto


1) Sacar solenoide. verivicar apertura y cierre, y verificar la solenoide. si presenta anomalias cambiar.
(foto)
2) abrir valvula desde arriba, destapar y limpiar bien.
(foto)
3) tapar, probar con agua de ser posible.
(foto)
4) avisar a RFV para que revise el trabajo ya que ellos son los responsbles.
5) si no se puede probar con agua programar fecha de test o hacer un ticket.
</p>
</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS5">Procedimiento limpieza flujometro (PTS5)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave de cadena.
- llave apriente.
- pano , cepillo para limpar.
- Flujometro de repuesto.
- cordon 3x075.

1) desmotar el flujometro con llave de cadena.
(foto)
2) limpiar impuresas.
3) Montar el flujometro.
</p>
</div> </div> 
<div class="row" >
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PTS6">2.4 Procedimiento Instalacion Flujometro (PTS6)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave de cadena.
- llave apriente.
- pano , cepillo para limpar.
- Flujometro de repuesto (con conector si es para milesight).
- cordon 3x075.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
-cinta aislante

si hay un flujometro viejo sacarlo.

1) desmotar el flujometro con llave de cadena.
(foto)

2) cablar el flujometro, son  un cable no haga parches, si no es necesario. si va a utilizar regleta use terminales, es preferible hacer conexiones con cinta aislante.

3) amarra los cables de esta forma, o conectarlos asi si es con regleta( es preferible amarrar que regleta ).
(foto como debe quedar amarrado y foto como debe quedar con borneta)

4) antes de encintar, verifique las tensiones de trabajo. conecte el flujometro y haga las mediciones.

Voltaje de alimentacion: ( foto del tester en cable rojo(+) y negro(-) ) respete polaridad tester. debe dar 3.2-4.2V.
Voltaje de datos: ( foto del tester en cable naranjo (data) y negro(-) ) debe soplar y debe dar la mitar del voltaje de alimientacion cuando sopla, (1.7V-2.1V) si deja de soplar deberia marcar 0V o el voltaje de alimentacion

si es tas medionces estan correctar, abra la caja ( ya sea milesight o sirecor) y sople por el flujometro hasta ver que marque en plataforma ( IoT cloud para milesight o smartbox para sirecor) si necesitado ayuda para
ver esta informnacion puede contactar a alguien que lo soporte.

Si no marca flujo pongase en contacto con ayuda tecnica.

5) encitar los cables o la union, colocar conduit y choco.
(foto mostrando la union, conduit y choco).

3) Montar el flujometro con llave de cadena.
(foto del trabajo terminado)

</p>
</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS7">2.5 Procedimiento ajustar reguladores voltaje sirecor (PTS7)</p>
<p class="m-3" style="white-space: pre-line;">
El regulador de la izquierda corresponde a la tensión de la carga de la batería BAT, para una batería de gel es necesario 13.9V a 14.2V, y un pack de 3 litio en serie 12,4 a 12,8 V. El regulador de la derecha alimenta el Microcontrolador y el módulo GSM MCU. Si estamos utilizando el módulo GSM SIM7600 (Actual) es necesario una tensión de 5v A 5.3V. En caso de que estemos utilizando el módulo GSM rojo SIM800 (descontinuado) la tensión necesaria es de 3.2v-3.5v.

</div> </div> 

<div class="row" > 
<div class="col m-3 d-flex justify-content-center" >

<div class="card" style="width: 18rem;">
  <img src="/images/imagenesDocs/pts7imagen1.png" class="card-img-top" >
  <div class="card-body">
    <p class="card-text">imagen 2.5.1</p>
  </div>
</div>

</div> </div> 

<div class="row" > 
<div class="col m-3" >

Para ajustar el regulador de carga de bateria BAT:
Con Panel solar de 12V ( tiene que estar al sol, midiendo al menos 17 V a circuito abierto ) 10 W a 20 W , conectamos a los primeros pines para regular la tensión de los reguladores (de izquierda a derecha positivo en primero (pin1) y negativo el segundo (pin2)). Cada regulador tiene un TRIM como se ve en la figura, y con un destornillador de cruz pequeño podemos variar el voltaje del regulador. Si no disponemos del panel solar, podemos utilizar una fuente de tensión regulable configurada a las tensiones deseadas según el tipo de batería y limitado a 700 mA ( solo para área técnica para testear en oficina).

</div> </div> 

<div class="row" > 
<div class="col m-3 d-flex justify-content-center" >

<div class="card" style="width: 18rem;">
  <img src="/images/imagenesDocs/pts7imagen2.png" class="card-img-top" >
  <div class="card-body">
    <p class="card-text">imagen 2.5.1</p>
  </div>
</div>

</div> </div> 


<div class="row" > 
<div class="col m-3" >

Conectamos el tester para medir tensión en los pin3 (+) y pin4(-) de la bornera de arriba.La batería tiene que estar desconectada. Regulamos la tensión según la batería. 13.9V a 14.2V para Batería GEL plomo, 12.4V a 12,8V para PACK 3 litio.

</div> </div> 

<div class="row" > 
    <div class="col m-3 d-flex justify-content-center" >

        <div class="card" >
            <img src="/images/imagenesDocs/pts7imagen3.png" class="card-img-top" >
            <div class="card-body">
                <p class="card-text">imagen 2.5.1</p>
            </div>
        </div>
    </div>
    <div class="col m-3 d-flex justify-content-center" >

        <div class="card" >
        <img src="/images/imagenesDocs/pts7imagen4.png" class="card-img-top" >
            <div class="card-body">
                <p class="card-text">imagen 2.5.1</p>
            </div>
        </div>

    </div> 
</div> 

<div class="row" > 
<div class="col m-3" >
Para ajustar el regulador de carga del microcontrolador MCU:
Ahora para regular el regulador MCU debemos desconectar el panel, luego conectar la batería para después, conectar el tester en la bornera de abajo en los pines 3(-) y 4(+). Con la ayuda de un destornillador regulamos la tensión del regulador a 5V aprox. (PARA SIM7600 ACTUAL), (3,3v para el SIM800 DESCOUNTINUADO).

</div> </div> 

<div class="row" > 
<div class="col m-3 d-flex justify-content-center" >

<div class="card" style="width: 18rem;">
  <img src="/images/imagenesDocs/pts7imagen5.png" class="card-img-top" >
  <div class="card-body">
    <p class="card-text">imagen 2.5.1</p>
  </div>

</div> </div> 

</p>

<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS8>2.6 Procedimiento Instalacion caja Enegizacion Milesight (PTS8) </p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.
- flujometro repuesto

1) instalar la caja de energizacion a EMT.

2) Si Probar la caja de energizacion podemos hacer los siguentes tests.

Test 1: Colocar el paner solar al sol o luz intensa. Esta medición comprueba que el voltaje del panel solar no supere los límites del circuito. Si mide menos de 8V a todo sol esta bien. Revisar que se prenda el led chraging.

 

Test 2: Revisar el voltaje de la bateria. Debe estar entre 3.2 y 4.2, si esta completamente cargada osea charged led encendido debe ser aprox 4.2. esperar a que la bateria se carge y que se prenda el led Charged, el voltaje medido debe ser aprox 4.2 V. Si no hay sol suficiente desconectar panel, y conectar el USB para cargar mediante USB. Durante la carga el voltaje debe ir subiendo.

 

Test 3: El voltaje a la salida del regulandor verde ( entre pin  Vo + y el pin GND - ) debe ser aprox 3,3V independiente si la bateria esta cargada o no.  SI es posible probar con una bateria con poca carga y una completamente cargada que el voltaje siempre sea 3.3V.

 </div> </div> 

 <div class="row" > 
    <div class="col m-3 d-flex justify-content-center" >

        <div class="card" >
            <img src="/images/imagenesDocs/Pts8imagen1.png" class="card-img-top" >
            <div class="card-body">
                <p class="card-text">imagen 2.1</p>
            </div>
        </div>
    </div>
</div>

2) conectar segun diagrama.



<div class="row" > 
    <div class="col m-3 d-flex justify-content-center" >

        <div class="card" >
            <img src="/images/imagenesDocs/Pts8imagen2.png" class="card-img-top" >
            <div class="card-body">
                <p class="card-text">imagen 2.5.1</p>
            </div>
        </div>
    </div>
</div>


</p>

<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PTS9" >Procedimiento configuracion milesight (PTS9)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

-smarphone con app de milesight tool box.

TODO, agregar todo el proceso que no me lo se. usar manual q dejo la paola


</p>
</div> </div>
 <div class="row" >
  <div class="col m-3" >

  <p class="h3 m-3" id="PT10" >2.7 Procedimiento Instalacion flotadores (PTS10) </p>
<p class="m-3" style="white-space: pre-line;">
TODO, mas adelante lo hago
</p>

</div> </div> 
<div class="row" > 
<div class="col m-3" >

<p class="h2 m-3">3 Procedimeintos de terreno PT </p>
<p class="m-3" style="white-space: pre-line;">
Son los procedimientos que se ejecutan en terreno. estos procedimientos contienen uno mas procedimietos
simples.

EJEMPLO: "Proced mantencion sirecor: -> incluye (PST1 mantecion panel) (PST2 Crear checklist) (PST3 limpieza valvula solenoide) (PST4 limpieza flujometro) (PST5 testes pilas litio)"

</p>
</div> </div>
 <div class="row" > 
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT1" >3.1 Procedimiento instalacion Sirecor (PT1) </p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.


1) coloque la caja en el EMT.

0) haga mantencion al panel si es necesario vea PST3.

2) abra la caja estanca y desconecte la bateria.

3) mida el voltajes necesarios para hcer el checklist.

4) regule los voltajes veta PTS7.

5) instales SIM card, panel bateria, con ferrulles
(foto)

6) instale flujometro vea PST6.

7) instale solenoide con ferrules.

(foto de todo instalado).

8) verifique apertura y cierre.

9) haga checklist, si no tiene conexion saque foto y grade la informacion para agregarlo cuando tenga senal. NO LO MANDE por wasap a no ser que tenga problemas con la plataforma, el checklist
lo es responsabilidad de quien instala el punto.

</p>
</div> </div>
 <div class="row" >
  <div class="col m-3" >
  
  <p class="h3 m-3" id="PT2" >Procedimiento instalacion Sirecor Estanque (PT2) </p>
<p class="m-3" style="white-space: pre-line;">
TODO
</p>
</div> </div>
 <div class="row" > 
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT3" >3.2 Procedimiento instalacion Milesight autoEnegizado (PT3) </p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.


1) coloque la caja en el EMT.

0) haga mantencion al panel si es necesario vea PST3.

2) abra la caja estanca y desconecte la bateria y conecte bateria.

3) configure la caja vea PST9.

4) verifique por plataforma que este conectado con el gateway o pida ayuda para que verifiquen, si no reninicie.


6) instale flujometro vea PST6.

7) instale solenoide con ferrules.

(foto de todo instalado).

8) verifique apertura y cierre.

9) haga checklist, si no tiene conexion saque foto y grade la informacion para agregarlo cuando tenga senal. NO LO MANDE por wasap a no ser que tenga problemas con la plataforma, el checklist
lo es responsabilidad de quien instala el punto.

</p>
</div> </div>
 <div class="row" > 
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT4" >Procedimiento instalacion Milesight con Caja de energizacion (PT4) </p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.


1) coloque la caja en el EMT.

0) haga mantencion al panel si es necesario vea PST3.

2) abra la caja estanca y desconecte la bateria y conecte bateria.

3) configure la caja vea PST9.

4) verifique por plataforma que este conectado con el gateway o pida ayuda para que verifiquen, si no reninicie.

5) instale caja de energizacion vea PST8.

6) instale flujometro vea PST6.

7) instale solenoide con ferrules.

(foto de todo instalado).

8) verifique apertura y cierre.

9) haga checklist, si no tiene conexion saque foto y grade la informacion para agregarlo cuando tenga senal. NO LO MANDE por wasap a no ser que tenga problemas con la plataforma, el checklist
lo es responsabilidad de quien instala el punto.
</p>
</div> </div> 
<div class="row" >
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT5" >Procedimeinto revision flujometro Milesight autoEnegizado (PT5)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.
- caja de energizacion.
- fusible 3.

1) vea si el fusible esta quemado, si esta quemado desconecte el flometro y coloque el fusible. verifique voltaje.
foto. debe dar el volatje de la bateria. si no tiene fusible y noesta dando tension corte el cable de modificacion y
instale caja de energizacion PST8.


2) instale flujometro PST6 , si no tiene la tension correcta por que la caja puede estar mal modificada. en ese caso, saque
el fusible, si no tiene corte el cable y instale caja de energizacion PST8.


3) trate de probar con agua o programe una prueba o en ultimo caso hace un ticket.


4) haga cehcklist PST3 agrage observacion si instalo la caja de energizacion.
</p>
</div> </div> 
<div class="row" >
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT6" >3.3 Procedimeinto revision flujometro Milesight con Caja de energizacion  (PT6)</p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.
- caja de energizacion.


1) cambie caja de energizacion PST8.


2) instale flujometro PST6 ,.


3) trate de probar con agua o programe una prueba o en ultimo caso hace un ticket.


4) haga cehcklist PST3 .
</p>
</div> </div> 
<div class="row" >
 <div class="col m-3" >
 
 <p class="h3 m-3" id="PT7" >3.4 Procedimeinto revision flujometro Sirecor (PT7)</p>

</div> </div> 

<div class="row" > 
<div class="col m-3" >

<p class="h3 m-3" id="PT8" >3.5 Procedimeinto revision Sirecor Estanque sensores de nivel (PT8) </p>


</div> </div> 

<div class="row" >
 <div class="col m-3" >

 <p class="h3 m-3" id="PT9" >3.6 Procedimeinto cambio de programa sirecor (PT9) </p>
<p class="m-3" style="white-space: pre-line;">
Herramientas

- llave apriente caja a emt.
- tester.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- cinta aislante
- Bornera
- llave de cadena.
- llave apriente.
- caja de energizacion.
- controladores con nuevo programa.

1) desconecte la el panel solar y luego la bateria.

2) saque el micro controlador y coloque el nuevo.

3) revise los votajes para hacer checklist PST3.

</p>
</div> </div>
 <div class="row" >
  <div class="col m-3" >

  <p class="h3 m-3" id="PT10" >3.7 Procedimeinto mantencion sirecor (PT10) </p>
</div> </div>

 <div class="row" >
  <div class="col m-3" >

  <p class="h3 m-3" id="PT11" >3.8 Procedimeinto mantencion sirecor Estanque (PT11) </p>
</div> </div>

 <div class="row" >
  <div class="col m-3" >

  <p class="h3 m-3" id="PT12" >3.9 Procedimeinto mantencion Milesight autoEnegizado (PT12) </p>
</div> </div>

 <div class="row" >
  <div class="col m-3" >

  <p class="h3 m-3" id="PT13" >3.10 Procedimeinto mantencion Milesight con Caja de energizacion </p>

</div>
</div>
</div>
</body>
';

       

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>