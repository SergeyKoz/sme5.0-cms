document.write("<DIV id='OutlookLikeBar' style='position:absolute;top:"+OB_Top+";left:"+OB_Left+";width:"+OB_Width+";height:"+OB_Height+";border:"+OB_BorderWidth+" "+OB_BorderStyle+" "+OB_BorderColor+";background-color:"+OB_BackgroundColor+";z-index:0;visibility:hidden;clip:rect(0,"+OB_Width+","+OB_Height+",0)'>");

document.write("<img onMouseUp='OutlookLikeBar.ArrowSelected(this)' onMouseDown='OutlookLikeBar.ArrowClicked(this)' onMouseOver='OutlookLikeBar.OverArrow(this)' onMouseOut='OutlookLikeBar.OutArrow(this)' id='OB_SlideUp' height='"+OB_ArrowHeight+"' width='"+OB_ArrowWidth+"' src='"+OB_UpArrow+"' style='position:absolute;top:0;left:0;cursor:hand;visibility:hidden;z-index:500'>");

document.write("<img onMouseUp='OutlookLikeBar.ArrowSelected(this)' onMouseDown='OutlookLikeBar.ArrowClicked(this)' onMouseOver='OutlookLikeBar.OverArrow(this)' onMouseOut='OutlookLikeBar.OutArrow(this)' id='OB_SlideDown' height='"+OB_ArrowHeight+"' width='"+OB_ArrowWidth+"' src='"+OB_DownArrow+"' style='position:absolute;top:0;left:0;cursor:hand;visibility:hidden;z-index:500'>");
j=1;
while(eval("window.OutBarFolder"+j))
    j++;
i=j-1;
while(i>0)
{
    Folder=eval("OutBarFolder"+i)
    //window.status="Outlook-Like Bar is making folder '"+Folder[0]+"'";
    if(i==1)
    {
        document.write("<INPUT class=but100percent position='UP' id='OB_Button1' onDblClick='OutlookLikeBar.FolderClicked("+i+");this.blur()' onClick='OutlookLikeBar.FolderClicked("+i+");this.blur()' TYPE='button' value='"+Folder[0]+"' style='position:absolute;top:0;left:0;height:"+OB_ButtonHeight+";font-family:"+OB_ButtonFontFamily+";font-size:"+OB_ButtonFontSize+"pt;cursor:hand;font-weight:bold;color:"+OB_ButtonFontColor+";z-index:100'>");
        document.getElementById("OB_Button1").position = document.getElementById("OB_Button1").getAttribute("position");
        MakeItems(Folder,i,OB_ButtonHeight);
    }
    else
    {
        document.write("<INPUT class=but100percent position='DOWN' id='OB_Button"+i+"' onDblClick='OutlookLikeBar.FolderClicked("+i+");this.blur()' onClick='OutlookLikeBar.FolderClicked("+i+");this.blur()' TYPE='button' value='"+Folder[0]+"' style='position:absolute;top:"+(OB_Height-(j-i)*OB_ButtonHeight-OB_BorderWidth*2)+";left:0;height:"+OB_ButtonHeight+";font-family:"+OB_ButtonFontFamily+";font-weight:bold;font-size:"+OB_ButtonFontSize+"pt;cursor:hand;color:"+OB_ButtonFontColor+";z-index:100'>");
        document.getElementById("OB_Button"+i).position = document.getElementById("OB_Button"+i).getAttribute("position");
        MakeItems(Folder,i,(OB_Height-(j-i)*OB_ButtonHeight-OB_BorderWidth*2)+OB_ButtonHeight);
    }
    i--;
}
document.write("</DIV>");


var OutlookLikeBar=new OutBar(OB_Width,OB_Height,j-1,OB_ButtonHeight,OB_BorderWidth,OB_SlideSpeed,OB_IconsHeight+OB_LabelFontSize+OB_LabelMargin+OB_ItemsSpacing,OB_ArrowSlideSpeed);
//window.status="Outlook-Like Bar successful created!";
document.getElementById("OutlookLikeBar").style.visibility="visible";



function MakeItems(Folder,zorder,top)
{
    var items=0;
    var folderWidth=(OB_Width-OB_BorderWidth*2);
    while(Folder[items+1])
        items+=4;
    items/=4;
    document.write("<DIV id='OB_Folder"+zorder+"' style='position:absolute;left:0;top:"+top+";width:"+folderWidth+";height:"+(OB_Margin*2+items*(OB_IconsHeight+OB_LabelFontSize+OB_LabelMargin)+(items-1)*OB_ItemsSpacing)+";z-index:"+zorder+";clip:rect(0 0 0 0);'>");
    for(var i=1;i<items*4;i+=4)
    {
        //document.write("<div targetFrame='"+Folder[i+3]+"' link='"+Folder[i+2]+"' onMouseDown='OutlookLikeBar.ItemClicked(this)' onMouseUp='OutlookLikeBar.ItemSelected(this)' onMouseOver='OutlookLikeBar.OverItems(this)' onMouseOut='OutlookLikeBar.OutItems(this)' style='position:absolute;left:"+(Math.ceil((OB_Width-OB_BorderWidth*2-OB_IconsHeight)/2)-1)+";top:"+(OB_Margin+Math.ceil((i-1)/4)*(OB_ItemsSpacing+OB_LabelFontSize+OB_IconsHeight))+";cursor:hand;clip:rect(0 "+OB_IconsWidth+" "+OB_IconsHeight+" 0;width:"+OB_IconsWidth+";height:"+OB_IconsHeight+"'>");
        document.write("<div targetFrame='"+Folder[i+3]+"' link='"+Folder[i+2]+"' onMouseDown='OutlookLikeBar.ItemClicked(this)' onMouseUp='OutlookLikeBar.ItemSelected(this)' onMouseOver='OutlookLikeBar.OverItems(this)' onMouseOut='OutlookLikeBar.OutItems(this)' style='position:absolute;left:"+(Math.ceil((OB_Width-OB_BorderWidth*2-OB_IconsHeight)/2)-1)+";top:"+(OB_Margin+Math.ceil((i-1)/4)*(OB_ItemsSpacing+OB_LabelFontSize+OB_IconsHeight))+";cursor:hand;clip:rect(0 "+OB_IconsWidth+" "+OB_IconsHeight+" 0;width:"+OB_IconsWidth+";height:"+OB_IconsHeight+"'>");
        //document.write("<img src='"+Folder[i]+"'border='0'>");
        //document.write("<a href='"+Folder[i+2]+"' target='"+Folder[i+3]+"'>");
        document.write("<img src='"+Folder[i]+"'border='0'>");
        //document.write("</a>");
        document.write("</div>");
        document.write("<div align='center' style='width:100%;text-align:center;position:absolute;left:0;top:"+(OB_LabelMargin+OB_IconsHeight+OB_Margin+Math.ceil((i-1)/4)*(OB_ItemsSpacing+OB_LabelFontSize+OB_IconsHeight))+";font-family:"+OB_LabelFontFamily+";font-size:"+OB_LabelFontSize+"pt;color:"+OB_LabelFontColor+"'>");
        document.write(Folder[i+1]);
        document.write("</div>");
    }
    document.write("</DIV>");
}


//***************************
//* Outlook-Like Bar Object *
//***************************
function OutBar(width,height,items,buttonHeight,borderWidth,slideSpeed,slideArrowValue,ArrowSlideSpeed)
{
    this.currentFolder=1;
    this.currentItem=null;
    this.slideCount=0;
    this.slideStep=10;
    this.slideArrowValue=slideArrowValue;
    this.slideSpeed=slideSpeed;
    this.borderWidth=borderWidth;
    this.width=width;
    this.visibleAreaHeight=height-2*borderWidth-items*buttonHeight;
    this.visibleAreaWidth=width;
    this.FolderClicked=FolderClicked;
    this.SlideFolders=SlideFolders;
    this.ItemClicked=ItemClicked;
    this.ItemSelected=ItemSelected;
    this.OverItems=OverItems;
    this.OutItems=OutItems;
    this.OverArrow=OverArrow;
    this.OutArrow=OutArrow;
    this.ArrowClicked=ArrowClicked;
    this.ArrowSelected=ArrowSelected;
    this.ArrowSlideSpeed=ArrowSlideSpeed;
    this.SlideItems=SlideItems;
    this.SlideItemsAction=SlideItemsAction;
    this.Start=Start;
    this.ClipFolder=ClipFolder;
    this.SetArrows=SetArrows;
    this.HideArrows=HideArrows;
    this.sliding=false;
    this.items=items;
    this.started=false;
    this.Start();
}

function FolderClicked(folder)
{
    //alert(this.sliding);
    if(this.sliding)
        return;
    if(folder==this.currentFolder)
        return;
    this.sliding=true;
    this.slideCount=this.visibleAreaHeight;
    this.slideStep=1210;
    this.countStep=0;
    this.HideArrows();

    //alert(folder+" "+document.getElementById("OB_Button"+folder).position);
    this.SlideFolders(folder,document.all["OB_Button"+folder].position=="DOWN");
}

function SlideFolders(folder,down)
{
    var step;
    if(down)
    {
        this.slideCount-=Math.floor(this.slideStep);
        if(this.slideCount<0)
            this.slideStep+=this.slideCount;
        step=Math.floor(this.slideStep);
        //alert(step);
        //alert(document.all["OB_Button"+3].style.top);
        //alert(document.all["OB_Button"+3].style.pixelTop);
        for(var i=2;i<=folder;i++)
            if(document.all["OB_Button"+i].position=="DOWN")
            {
                //alert(document.all["OB_Button"+i].style.pixelTop);
                btop = parseInt(document.all["OB_Button"+i].style.top) - step;
                ftop = parseInt(document.all["OB_Folder"+i].style.top) - step;

                document.all["OB_Button"+i].style.top = btop+"px";
                document.all["OB_Folder"+i].style.top = ftop+"px";

                //document.all["OB_Button"+i].style.pixelTop-=step;
                //document.all["OB_Folder"+i].style.pixelTop-=step;

            }

        filter = /rect\((\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1}\)/;

        var clipString=document.all["OB_Folder"+folder].style.clip;
        //alert(clipString);
        var clip=clipString.match(filter);
        //alert(clip);
        this.ClipFolder(folder,parseInt(clip[1]),this.visibleAreaWidth,(parseInt(clip[3])+step),0);

        var clipString=document.all["OB_Folder"+this.currentFolder].style.clip;
        var clip=clipString.match(filter);
        this.ClipFolder(this.currentFolder,parseInt(clip[1]),this.visibleAreaWidth,(parseInt(clip[3])-step),0);

        this.slideStep*=this.slideSpeed;
        if(this.slideCount>0){
            setTimeout("OutlookLikeBar.SlideFolders("+folder+",true)",2);
        } else
        {
            for(var k=2;k<=folder;k++) {
            //alert(document.all["OB_Button"+k].position);
                document.all["OB_Button"+k].position="UP";
            }
            this.currentFolder=folder;
            this.SetArrows();
            this.sliding=false;
        }
    }
    else
    {
        this.slideCount-=Math.floor(this.slideStep);
        if(this.slideCount<0)
            this.slideStep+=this.slideCount;
        step=Math.floor(this.slideStep);
        for(var i=folder+1;i<=this.items;i++)
            if(document.all["OB_Button"+i].position=="UP")
            {

                btop = parseInt(document.all["OB_Button"+i].style.top) + step;
                ftop = parseInt(document.all["OB_Folder"+i].style.top) + step;

                document.all["OB_Button"+i].style.top = btop+"px";
                document.all["OB_Folder"+i].style.top = ftop+"px";


                //document.all["OB_Button"+i].style.pixelTop+=step;
                //document.all["OB_Folder"+i].style.pixelTop+=step;
            }

        filter = /rect\((\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1}\)/;
        //filter = /rect\((\d*)px (\d*)px (\d*)px (\d*)px\)/;

        var clipString=document.all["OB_Folder"+folder].style.clip;
        var clip=clipString.match(filter);
        this.ClipFolder(folder,parseInt(clip[1]),this.visibleAreaWidth,(parseInt(clip[3])+step),0);

        var clipString=document.all["OB_Folder"+this.currentFolder].style.clip;
        var clip=clipString.match(filter);
        this.ClipFolder(this.currentFolder,parseInt(clip[1]),this.visibleAreaWidth,(parseInt(clip[3])-step),0);

        this.slideStep*=this.slideSpeed;
        if(this.slideCount>0)
            setTimeout("OutlookLikeBar.SlideFolders("+folder+",false)",2);
        else
        {
            for(var k=folder+1;k<=this.items;k++)
                document.all["OB_Button"+k].position="DOWN";
            this.currentFolder=folder;
            this.SetArrows();
            this.sliding=false;
        }
    }
}

function ItemClicked(item)
{
    if(this.sliding)
        return;
    //item.style.borderStyle="inset";
    //item.style.borderColor="#FFFFFF";
    //item.style.borderWidth="2px";


}

function ItemSelected(item)
{
    if(this.sliding)
        return;

    __targetFrame=item.getAttribute("targetFrame");
    __link = item.getAttribute("link");
    //alert(__targetFrame);
   // item.style.border="1 outset #ffffff";

    //item.style.borderStyle="outset";
    //item.style.borderColor="#FFFFFF";
    //item.style.borderWidth="1px";

    //alert(item.link);
    if(__link.indexOf("javascript")!=-1) {
        eval(__link);
    } else {
        eval(__targetFrame+".location='"+__link+"'");
    }
}

function OverItems(item)
{
    if(this.sliding)
        return;
    //item.style.border="1 outset #ffffff";
    //item.style.borderStyle="outset";
    //item.style.borderColor="#FFFFFF";
    //item.style.borderWidth="1px";
}

function OutItems(item)
{
    if(this.sliding)
        return;
    //item.style.border="0 none black";
    //item.style.borderStyle="none";
    //item.style.borderColor="#000000";
    //item.style.borderWidth="0px";

}

function ArrowClicked(arrow)
{
    if(this.sliding)
        return;
    //arrow.style.border="1 inset #ffffff";
    //arrow.style.borderStyle="inset";
    //arrow.style.borderColor="#FFFFFF";
    //arrow.style.borderWidth="1px";

}

function ArrowSelected(arrow)
{
    if(this.sliding)
        return;
    //arrow.style.border="0 none black";
    //arrow.style.borderStyle="none";
    //arrow.style.borderColor="#000000";
    //arrow.style.borderWidth="0px";

    this.SlideItems(arrow.id=="OB_SlideUp");
}

function OverArrow(arrow)
{
    if(this.sliding)
        return;
    //arrow.style.border="1 outset #ffffff";
    //arrow.style.borderStyle="outset";
    //arrow.style.borderColor="#FFFFFF";
    //arrow.style.borderWidth="1px";

}

function OutArrow(arrow)
{
    if(this.sliding)
        return;
    //arrow.style.border="0 none black";
    arrow.style.borderStyle="none";
    arrow.style.borderColor="#000000";
    arrow.style.borderWidth="0px";

}

function ClipFolder(folder,top,right,bottom,left)
{

    document.getElementById("OB_Folder"+folder).style.clip='rect('+top+' '+right+' '+bottom+' '+left+')';
}

function Start()
{
    if(!this.started)
    {

        this.ClipFolder(1,0,this.visibleAreaWidth,this.visibleAreaHeight,0);
        this.SetArrows();
    }
}

function SetArrows()
{
    document.getElementById("OB_SlideUp").style.pixelTop=document.getElementById("OB_Button"+this.currentFolder).style.pixelTop+document.getElementById("OB_Button"+this.currentFolder).style.pixelHeight+20;
    document.getElementById("OB_SlideUp").style.pixelLeft=this.width-document.getElementById("OB_SlideUp").width-this.borderWidth-10;
    document.getElementById("OB_SlideDown").style.pixelTop=document.getElementById("OB_Button"+this.currentFolder).style.pixelTop+document.getElementById("OB_Button"+this.currentFolder).style.pixelHeight+this.visibleAreaHeight-document.getElementById("OB_SlideDown").height-20;
    document.getElementById("OB_SlideDown").style.pixelLeft=this.width-document.getElementById("OB_SlideDown").width-this.borderWidth-10;

    var folder=document.getElementById("OB_Folder"+this.currentFolder).style;
    var startTop=document.getElementById("OB_Button"+this.currentFolder).style.pixelTop+document.getElementById("OB_Button"+this.currentFolder).style.pixelHeight;


    //alert(folder.pixelHeight+" "+startTop+" "+folder.pixelTop+" "+this.visibleAreaHeight+" \n "+folder.pixelTop+" "+startTop);
    if(folder.pixelTop<startTop)
        document.getElementById("OB_SlideDown").style.visibility="visible";
    else
        document.getElementById("OB_SlideDown").style.visibility="hidden";

    if(folder.pixelHeight-(startTop-folder.pixelTop)>this.visibleAreaHeight)
        document.getElementById("OB_SlideUp").style.visibility="visible";
    else
        document.getElementById("OB_SlideUp").style.visibility="hidden";
}

function HideArrows()
{
    document.getElementById("OB_SlideUp").style.visibility="hidden";
    document.getElementById("OB_SlideDown").style.visibility="hidden";
}

function SlideItems(up)
{
    this.sliding=true;
    this.slideCount=Math.floor(this.slideArrowValue/this.ArrowSlideSpeed);
    up ? this.SlideItemsAction(-this.ArrowSlideSpeed) : this.SlideItemsAction(this.ArrowSlideSpeed);
}

function SlideItemsAction(value)
{

    document.all["OB_Folder"+this.currentFolder].style.pixelTop+=value;

    filter = /rect\((\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1}\)/;
    //filter = /rect\((\d*)px (\d*)px (\d*)px (\d*)px\)/;


    var clipString=document.getElementById("OB_Folder"+this.currentFolder).style.clip;
    var clip=clipString.match(filter);
    this.ClipFolder(this.currentFolder,(parseInt(clip[1])-value),parseInt(clip[2]),(parseInt(clip[3])-value),parseInt(clip[4]));
    this.slideCount--;
    if(this.slideCount>0)
        setTimeout("OutlookLikeBar.SlideItemsAction("+value+")",20);
    else
    {
        if(Math.abs(value)*this.ArrowSlideSpeed!=this.slideArrowValue)
        {
            document.all["OB_Folder"+this.currentFolder].style.pixelTop+=(value/Math.abs(value)*(this.slideArrowValue%this.ArrowSlideSpeed));
            //filter = /rect\((\d*)px (\d*)px (\d*)px (\d*)px\)/;
            filter = /rect\((\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1} (\d*)p[xt],{0,1}\)/;
            var clipString=document.getElementById("OB_Folder"+this.currentFolder).style.clip;
            var clip=clipString.match(filter);
            this.ClipFolder(this.currentFolder,(parseInt(clip[1])-(value/Math.abs(value)*(this.slideArrowValue%this.ArrowSlideSpeed))),parseInt(clip[2]),(parseInt(clip[3])-(value/Math.abs(value)*(this.slideArrowValue%this.ArrowSlideSpeed))),parseInt(clip[4]));
        }
        this.SetArrows();
        this.sliding=false;
    }
}