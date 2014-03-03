
<style type="text/css" >
	#unityPlayer, #unityPlayer2 {
		width: 640px;
		height: 480px;
	}
</style>

<!--<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>-->

<div class="content">
    <?php if($ext_file==2): ?>
  	<div id="unityPlayer" style="width: 640px; height: 480px; visibility: visible;"> 
  		<embed type="application/vnd.unity" style="display: block; width: 100%; height: 100%;" width="640" height="480" tabindex="0" firstframecallback="unityObject.firstFrameCallback();" src="assets/files/games/roms/<?=$game['base_path'].$game['gamefile']?>">
  	</div>
    <?php else: ?>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?=$game['game_width']?>" height="<?=$game['game_height']-80?>" id="<?=$game['slug']?>" title="<?=$game['title']?>">
      <param name="movie" value="assets/files/games/roms/<?=$game['base_path'].$game['gamefile']?>" />
      <param name="quality" value="high" />
      <param name="wmode" value="opaque" />
      <param name="swfversion" value="11.0.0.0" />
      <param name="base" value="assets/files/games/roms/<?=$game['base_path']?>">
      <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
      <param name="expressinstall" value="Scripts/expressInstall.swf" />
      <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
      <!--[if !IE]>-->
      <object type="application/x-shockwave-flash" data="assets/files/games/roms/<?=$game['base_path'].$game['gamefile']?>" width="<?=$game['game_width']?>" height="<?=$game['game_height']-80?>">
        <!--<![endif]-->
        <param name="quality" value="high" />
        <param name="wmode" value="opaque" />
        <param name="swfversion" value="11.0.0.0" />
        <param name="base" value="assets/files/games/roms/<?=$game['base_path']?>">
        <param name="expressinstall" value="Scripts/expressInstall.swf" />
        <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
        <div>
          <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
          <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
        </div>
        <!--[if !IE]>-->
      </object>
      <!--<![endif]-->
    </object>
<?php endif; ?>
  <?php if(!$partner): ?>
  <a class="tak_terminarjuego2" href="resultado/<?=$game['slug']?>" target="_top" >Ir al sal&oacute;n de la fama</a>
  <?php endif; ?>
</div>
    
    
<!--    <script type="text/javascript">
swfobject.registerObject("FlashID");
    </script>-->
