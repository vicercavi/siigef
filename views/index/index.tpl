<style type="text/css">
#raizaMenu {
   padding-top: 10px;   
}
@media (min-width: 1200px){
  #raizaMenu {  
     margin-left: 8.33333333%;
  }
}
@media(max-width: 991px){
  #raizaMenu ul{
      height: 40px !important;
  }
}
#raizaMenu ul{
   list-style: none;
   width: 100%;
    height: 20px;
      padding: 0px 10px;
}
#raizaMenu li{
   top: 3px;
   margin: 0px 2px;
   float: left;
}
#raizaMenu li .actual{
  color: #444f4a;
}
#raizaMenu a{
   margin: 0px 3px;
   color: #03a506;
}
.alert-info {
    color: #31708f !important;
    background-color: #d9edf7 !important;
    border-color: #bce8f1;
}
</style>
<div id="raizaMenu" clas="col-xs-3 col-sm-3 col-md-2 col-lg-2">
  {if isset($menuRaiz) && count($menuRaiz[0][0] && !empty($menuRaiz[0][0]))}
  <ul clas="col-xs-3 col-sm-3 col-md-2 col-lg-2">
    <li>
      <a href="{$_layoutParams.root}">{$lenguaje["label_inicio"]} </a>
    </li>
    {foreach from=$menuRaiz item=mr}
      {$mr[0]}
    {/foreach}
  </ul>     
  {/if}
</div>
<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-lg-offset-1" style="margin-top: 10px;">
    {if isset($widgets.sidebar)}
    <nav class="navbar ">
      {foreach from=$widgets.sidebar item=wd}
          <ul class="dropdown-menu col-xs-12" role="menu" aria-labelledby="dropdownMenu" style="margin-bottom: 5px; display: block; position: static; border: 1px solid rgba(0, 0, 0, .15);
          border-radius: 4px; -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
          box-shadow: 0 6px 12px rgba(0, 0, 0, .175);">  
          {$wd}
          </ul>
      {/foreach}
    </nav>
    {/if}    
</div>
<section class="col-xs-12 col-sm-8 col-md-offset-0 col-md-8 col-lg-offset-0 col-lg-8">
    <!--<div id="carousel" style="transform: translateZ(-288px) rotateY(-320deg);">-->
    <div id="enlaces" >
        {$datos.Pag_Contenido}
    </div>        
</section>

