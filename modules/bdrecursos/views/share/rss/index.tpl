<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
        <title>{$rss_titulo}</title>
        <link>{$rss_url}</link> 
        <description>{$rss_descripcion}</description>
        {if $arg1=='recurso'}
        	{foreach item=recurso from=$recursos}
	        <item>
	        	<title>{$recurso['Rec_Nombre']}</title>
	        	<link>{$_layoutParams.root}bdrecursos/metadata/index/{$recurso['Rec_IdRecurso']}</link>
	        	<category>{$recurso['Esr_Nombre']}</category>
	        	<description>{$recurso['Rec_Origen']} | {$recurso['Tir_Nombre']}></description>
	        	<author>{$recurso['Rec_Fuente']}></author>
	        	<guid>{$_layoutParams.root}bdrecursos/metadata/index/{$recurso['Rec_IdRecurso']}</guid>
	        	<pubDate>{$recurso['Rec_UltimaModificacion']}</pubDate>
        	</item>
	    {/foreach}    
        {/if}           
    </channel>
</rss>