<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';


    $HtmlPage='
 <body>	
	
<div class="container p-3" >
<div class="row m-3 p-3" >

<h1>Procedimeintos</h1>
<h2>Metodologia de trabajo</h2>

<p>El equipo de Desarrollo eco3 utiliza Metodologias agiles para realizar proyectos.
Se utiliza el Scrum como marco de trabajo. Los proyectos son a corto plazo (1 semana)
y estan relacionados a Investigacion o mejoras a proyectos existentes.</p>

<p>Con los sprint de scrum abarcamos todo lo nuevo, pero cuando las cosas fallan utilizamos
tickets para revisar los problemas que vayan a pareciendo en los proyectos existentes.</p>

<h2>Sprints</h2>

<p>Los sprints son cilcos cortos de trabajo que culminan en un producto entregable funcional.
Los sprints estan asociados a una historia de usuario, que es una funcionalidad que el
cliente ( gerencia ECO3 ) va a disponer luego de terminar el sprint.

EL SPRINT NO ES UNA LISTA DE TAREAS. Las tereas son creadas en funcion de la historia de usuario.

Una historia de usuario es una descripción breve, simple y no técnica de una funcionalidad,
escrita desde la perspectiva del usuario final (cliente o usuario) para expresar una necesidad y el valor que aporta.

EJEMPLO: "Como usuario quiero ver la presion en los cuarteles A, B, C"

Las Tareas, son todo lo necesario para que la funcionalidad sea posible.

EJEMPLO:"1) instalar sensores de presion en los cuarteles A, B, C".
        "2) crear una platafor de visualicacion de presion".

Las tareas de terreno, muchas estan estandarizadas. Mas adelante se muestran los procedimientos para
tereas que estan estandarizadas. Asi todas las tareas estan relacionados a un procedimiento que determina
como hacer la tarea.

EJEMPLO:"1) instalar sensores de presion en los cuarteles A, B, C. (P123)"
        "P123 procedimiento para instalacion de sensiores de presion.
            Herramientas necesarias....
            Tiempo estimado....

            1) abrir la linea desde ...
            2) conectar los cable...
            3) instalar programa..
            4) testar desde.."

Si hay tareas que no tienen un procedimiento y es repetitiva o ya se a ha hecho antes, es necesario crear un procedimiento
para que la tarea este estandarizada.

Ejemplo "(sin procedimiento) Tarea: Ajustar paner solar para que tenga orientacion norte y tenga un angulo de 60
        Luego de hacer la tarea, crear un procedimiento para estandarizar (p124 creado)
        otra tarea de otro sprint Tarea: Ajustar paner solar para que tenga orientacion norte y tenga un angulo de 60, usar procedimeinto (p124)."


Todas las tareas estan en funcion una historia, todas las historias estan en funcion de un product Backlog
todos los backlogs estan en funcion de un Objetivo.

Ejemplo:

Proyecto Iot Minera X,

[     Cliente        ]
[         gerencia ECO3                                         ]
                                        [               Equipo Desarrollo                      ]
                                        [                   ciclo SCRUM                             ]
(Objetivo)           ( Product Backlog ) ( Historia de usuario )    ( Tareas )   ( Procedimeintos ).

Riego Foestacion A   -Control remoto ---> como usuario abrir -> -Fabricar dispositivos --> (P123)
                                          remotamente.         - Instalar dispositivos --> (P124)
                                                              -plataforma crear alerta --> sin procedimeinto
                     -riego nocturno

                     -ecoData

                     ... etc
</p>


<h2> Procedimeintos de SIMPLES terreno    </h2>

<p>Son procedimeinto que realizan una funcion especifica.
Los procedimientos simple no incluye otros procedimietos.

<h3>Procedimiento  Sirecor Crear checklist (PTS2)   </h3>
herramientas: smarphone.

1) entrar pagina de smartbox www.smartbox.eco3.cl

2) Iniciar sesion, en la pagina pricipal elegir la unidad la ultima columa hay una vinculo con la palabra VER, a la cual se hara el checklist.
Si la unidad es sirecor y es nueva, hay que conectarla y ver en unidades indefinidas, buscar por el IMEI de la placa. Luego hacer click en el
viculo ver. SI es milesight nueva debe hablar con el equipo de desarrollo para que la agrege. si es milesight buscala en la tabla milesight.
(agregar foto del vinculo)

3) una ves dentro de la unidad hacer click en el viculo nuevo checklist.
(agregar foto)

4)Ahora hay que completar el checklist con la informacion de terreno. Los valores esperados estan en los campos( agregar foto)
NO UTILICES CARACTERES NO NUMERICOS COMO LETRAS O SIGNOS. solo tienes que agregar el valor del voltaje con punto . si tiene decimal.
(agregar foto)

5) checkea todas las funciones que fueron testeadas.
(agregar foto)

6) agrega tu nombre y un comentario, si tienes algunas observacion del punto algo que no se pudo medir o extrano agregalo todo es necesario.
si no tiene observaciones coloca OK, no puedes dejar el campo vacio.
(agregar foto)

7) has click para buscar la foto del checklist, la foto debe ojala aparecer toda la estructura la valvula y la solenoide, que se vean los chochos y el counduit
(agregar foto)

8) has click en upload para subir la foto. debe aparecer el nombre de la foto en el campo URL_foto.
(agregar foto)

9)Ahora dar subir enviar checklist. si no tienes errores en los campos dar OK, sino corrigelos. esperar unos segundo debe aperecer un mensaje con los datos enviados.
v

10) revisa en smartbox que el checklist se haya creado correctamente. abre el vinculo VER en la paguina de inicio y aseguratge que se haya subido el checklist.
(agregar foto)

11) si tienes problemas contanta con el equipo de desarrollo, guarta toda la informacion, envia la foto con los datos por el grupo de IOT de teams para que sea agregado mas tarde.

</p>
<h3>Procedimiento  Sirecor mantecion panel (PTS3)  </h3>
<p>
herramientas:
- pano para limpiar panel.
- liquido limpieza panel.
- Destornillador petillero.
- terminal ferrulle.
- aprieta terminal ferrulle.
- smartphone.
- llave inglesa para apretar tuerca.
-tester

1) limpar panel con el liquido, tiene que quedar reluciente.

2) con aplicacion de blujula, apuntar el panel al norte. ajustar a -30 grados.
(foto)

3) desmontar los cable del panel y medir voltaje a circuito abierto. a todo sol debe medir 19v al menos. mover el cable para descartar malas conexiones.
(foto)

4) si los terminales estan oxidadoes o no tiene terminales, cambiar terminales.

</p>
<h3>Procedimiento limpieza valvula solenoide (PTS4)</h3>
<p>
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
<h3>Procedimiento limpieza flujometro (PTS5)</h3>
<p>

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
<h3>Procedimiento Instalacion Flujometro (PTS6)</h3>
<p>
Herramientas

- llave de cadena.
- llave apriente.
- pano , cepillo para limpar.
- Flujometro de repuesto (con conectaro si es para milesight).
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
<h3>Procedimiento ajustar reguladores voltaje sirecor (PTS7)</h3>
<p>
El regulador de la izquierda corresponde a la tensión de la carga de la batería BAT, para una batería de gel es necesario 13.9V a 14.2V, y un pack de 3 litio en serie 12,4 a 12,8 V. El regulador de la derecha alimenta el Microcontrolador y el módulo GSM MCU. Si estamos utilizando el módulo GSM SIM7600 (Actual) es necesario una tensión de 5v A 5.3V. En caso de que estemos utilizando el módulo GSM rojo SIM800 (descontinuado) la tensión necesaria es de 3.2v-3.5v.



Para ajustar el regulador de carga de bateria BAT:
Con Panel solar de 12V ( tiene que estar al sol, midiendo al menos 17 V a circuito abierto ) 10 W a 20 W , conectamos a los primeros pines para regular la tensión de los reguladores (de izquierda a derecha positivo en primero (pin1) y negativo el segundo (pin2)). Cada regulador tiene un TRIM como se ve en la figura, y con un destornillador de cruz pequeño podemos variar el voltaje del regulador. Si no disponemos del panel solar, podemos utilizar una fuente de tensión regulable configurada a las tensiones deseadas según el tipo de batería y limitado a 700 mA ( solo para área técnica para testear en oficina).


Conectamos el tester para medir tensión en los pin3 (+) y pin4(-) de la bornera de arriba.La batería tiene que estar desconectada. Regulamos la tensión según la batería. 13.9V a 14.2V para Batería GEL plomo, 12.4V a 12,8V para PACK 3 litio.


Para ajustar el regulador de carga del microcontrolador MCU:
Ahora para regular el regulador MCU debemos desconectar el panel, luego conectar la batería para después, conectar el tester en la bornera de abajo en los pines 3(-) y 4(+). Con la ayuda de un destornillador regulamos la tensión del regulador a 5V aprox. (PARA SIM7600 ACTUAL), (3,3v para el SIM800 DESCOUNTINUADO).


agregar fotos

</p>
<h3>Procedimiento Instalacion caja autoEnegizacion milesight (PTS8) </h3>
<p>
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

2) conectar segun diagrama.
( agregar foto)

</p>
<h3>Procedimiento configuracion milesight (PTS9)</h3>
<p>
Herramientas

-smarphone con app de milesight tool box.

TODO, agregar todo el proceso que no me lo se. usar manual q dejo la paola


</p>
<h3>Procedimiento Instalacion flotadores (PTS10) </h3>
<p>
TODO, mas adelante lo hago
</p>

<h2> Procedimeintos de terreno PT </h2>
<p>
Son los procedimientos que se ejecutan en terreno. estos procedimientos contienen uno mas procedimietos
simples.

EJEMPLO: "Proced mantencion sirecor: -> incluye (PST1 mantecion panel) (PST2 Crear checklist) (PST3 limpieza valvula solenoide) (PST4 limpieza flujometro) (PST5 testes pilas litio)"

</p>
<h3>Procedimiento instalacion Sirecor (PT1) </h3>
<p>
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
<h3>Procedimiento instalacion Sirecor Estanque (PT2) </h3>
<p>
TODO
</p>
<h3>Procedimiento instalacion Milesight autoEnegizado (PT3) </h3>
<p>
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
<h3>Procedimiento instalacion Milesight con Caja de energizacion (PT4) </h3>
<p>
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
<h3>Procedimeinto revision flujometro Milesight autoEnegizado (PT5)</h3>
<p>
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
<h3>Procedimeinto revision flujometro Milesight con Caja de energizacion  (PT6)</h3>
<p>
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
<h3>Procedimeinto revision Sirecor (P7)</h3>

<h3>Procedimeinto revision Sirecor Estanque sensores de nivel (PT8) </h3>

<h3>Procedimeinto cambio de programa sirecor (PT9) </h3>
<p>
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
<h3>Procedimeinto mantencion sirecor (PT11) </h3>

<h3>Procedimeinto mantencion sirecor Estanque (PT12) </h3>

<h3>Procedimeinto mantencion Milesight autoEnegizado (PT13) </h3>

<h3>Procedimeinto mantencion Milesight con Caja de energizacion (PT14) </h3>

</div>
</div>
</body>
';

       

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>