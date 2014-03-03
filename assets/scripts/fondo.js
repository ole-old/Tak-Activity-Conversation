

var backgr1="assets/images/frontend/jirafa.jpg"
var backgr2="assets/images/frontend/iguana.jpg"
var backgr3="assets/images/frontend/iguanita.jpg"
var backgr4="assets/images/frontend/pelos.jpg"
var backgr5="assets/images/frontend/estrellas.jpg"
var backgr6="assets/images/frontend/burbujas_azules.jpg"
var backgr7="assets/images/frontend/rayas_verdes.jpg"
var backgr8="assets/images/frontend/rayas_moradas.jpg"
var backgr9="assets/images/frontend/rayas_azulclaro.jpg"
var cur=Math.round(8*Math.random())
switch (cur) {

case 0 :
backgr=backgr1;
break;
case 1 :
backgr=backgr2;
break;
case 2 :
backgr=backgr3;
break;
case 3 :
backgr=backgr4;
break;
case 4 :
backgr=backgr5;
break;
case 5 :
backgr=backgr6;
break;
case 6 :
backgr=backgr7;
break;
case 7 :
backgr=backgr8;
break;
default :
backgr=backgr9;
break;
}

   document.write('<body background="'+backgr+'" bgproperties="no-repeat" bgcolor="#ffffff" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">')
