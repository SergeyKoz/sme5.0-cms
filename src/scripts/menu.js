var OpenMenu=new Array();
var Timer=null;
var PageWidth=776;

var Vers=parseInt(navigator.appVersion);
var Netscape4=(document.layers) ? true : false;
var IExplorer4=((document.all)&&(Vers>=4))?true:false;
var Netscape6=(!IExplorer4 && document.getElementById) ? true : false;


function clearTimer()
  {
   if (Timer)
     {
      clearTimeout (Timer);
      Timer = null;
     }
  }

function setTimer()
  {
   Timer = window.setTimeout('CloseAll(0)', 250);
  }

function ShowMenu(id,  level,  place)
  {
   clearTimer();
   if (IExplorer4){
     return ShowMenuE(id,  level,  place);
   }
   if (Netscape6){
     return ShowMenuN(id,  level,  place);
   }
   return true;
  }

function GetRecursiveOffsetY(object, offset){

    if(object.parentNode){
         if((object.nodeName != "FORM") && (object.nodeName != "TR") && (object.nodeName != "THEAD") && (object.nodeName != "TBODY")){
             offset += object.offsetTop
         }
         return GetRecursiveOffsetY(object.parentNode, offset);
    } else {
        return offset;
    }
}

function GetRecursiveOffsetX(object, offset){
    if(object.parentNode){
         if((object.nodeName != "FORM") && (object.nodeName != "TR") && (object.nodeName != "THEAD") && (object.nodeName != "TBODY")){
             offset += object.offsetLeft
         }
         return GetRecursiveOffsetX(object.parentNode, offset);
    } else {
        return offset;
    }
}



function ShowMenuE(id, level,  place)
  {
   elem = document.getElementById(id);
   if (OpenMenu[level] && OpenMenu[level]!=elem)
     CloseAll(level);
   if (elem == null)
     return true;

	var addX=37, addY=-7;

	var offset = $('#'+id).parent().offset();

	elem.style.top=offset.top + addY;
	elem.style.left=offset.left + addX ;

   document.getElementById(id).style.display = "block";
   document.getElementById(id).style.visibility = "visible";
   OpenMenu[level]=elem;
   return false;
  }



function ShowMenuN(id,  level,  place)
  {
   if (OpenMenu[level] && OpenMenu[level]!=id){
       CloseAll(level);
   }
   elem = document.getElementById(id);
   if (elem == undefined)
     return true;


   var addX=37, addY=-7;

	var offset = $('#'+id).parent().offset();


	elem.style.top=offset.top + addY;
	elem.style.left=offset.left + addX ;

   if((parseInt(elem.style.left) + 180) > document.width){
     elem.style.left = document.width - 180;
   }

   elem.style.visibility = "visible";
   elem.style.display = "block";
   OpenMenu[level]=id;
   return false;
  }

function CloseMenu(level)
  {
   if (IExplorer4)
     return CloseMenuE(level);
   if (Netscape6)
     return CloseMenuN(level);
   return true;
  }

function CloseMenuE(level)
  {
   if (OpenMenu[level])
     {
      OpenMenu[level].style.display = "none";
      OpenMenu[level].style.visibility = "hidden";
     }
   OpenMenu[level]=null;
  }

function CloseMenuN(level)
  {
   if (OpenMenu[level])
     {
      document.getElementById(OpenMenu[level]).style.visibility = "hidden";
      document.getElementById(OpenMenu[level]).style.display = "none";
     }
   OpenMenu[level]=null;
  }

function CloseAll(level)
  {
   clearTimer();
   for (i=level; i<OpenMenu.length; i++)
     CloseMenu(i);
  }

function GetYPos(elem)
  {
   var pos = elem.offsetTop;
   while (elem.offsetParent != null)
     {
      elem = elem.offsetParent;
      pos += elem.offsetTop;
      if (elem.tagName == 'BODY') break;
     }
   return pos;
  }

function ScrollTo(which)
  {
   if (document.all.item(which) == null)
     return true;
   var elem = eval(which);
   targetPos=GetYPos(elem);
   docLength=GetYPos(docEndImg);
   if ((docLength-targetPos) > (document.body.clientHeight-Header.offsetHeight))
     document.body.scrollTop = targetPos-Header.offsetHeight;
   else
     document.body.scrollTop = docLength-document.body.clientHeight;
   CloseAll(0);
   return false;
  }

function ScrollPriceHeader()
  {
   if (document.body.scrollTop>132)
     {
      Header.style.top = document.body.scrollTop-132;
      var i=0;
      while (elem=document.all.item("grouplist"+i++))
        elem.style.top = document.body.scrollTop+34; // оглавление здесь
     }
   else
     {
      Header.style.top = 0;
      var i=0;
      while (elem=document.all.item("grouplist"+i++))
        elem.style.top = 166; // и здесь тоже оглавление
     }
  }

function ShowHide(elem)
  {
   if (document.getElementById(elem).style.display == "none")
     document.getElementById(elem).style.display = "block";
   else
     document.getElementById(elem).style.display = "none";
  }
