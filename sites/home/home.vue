<template>
    <div id="homeContainer">
        <span class="scrollTriangle textWhite" data-to-section="1">▼</span>
    	<section style = 'background-color: black;' class="navSection FullHeight" data-section-id="0">
    		<p id="fractavaNameText">FRACTAVA</p>
    	</section>
    	<section style = 'background-color: white;' class="navSection FullHeight" data-section-id="1">
    		<p class="textBlack">Diese Seite befindet sich zur Zeit im Umbau</p>
    	</section>
    </div>
</template>

<script>
    export default {
        "methods": {
        },
        "computed": {
        },
        "watch": {
        },
        "lang": {
        }
    }
</script>

<style>
    #fractavaNameText{
        position: relative;
        left: 50%;
        top:50%;
        transform: translate(-50%,-50%);
        color: white;
        font-family: nextfont;
        font-size: calc(4vw + 4vh + 2vmin);
        text-align: center;
    	margin: 0;
    }
</style>