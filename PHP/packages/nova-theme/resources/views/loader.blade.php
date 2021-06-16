<div id="app-loader" class="absolute w-full h-full flex justify-center items-center">
    <div style="margin: 0 10px"><div class="bounce-ball"></div></div>
    <h2>Loading </h2>
</div>

<style>
    #app-loader {
        background: rgba(255, 255, 255, 0.5);
        z-index: 1000;
    }

    .bounce-ball {
        position: relative;
        display: inline-block;
        height: 50px;
        width: 15px;
    }

    .bounce-ball:before {
        position: absolute;
        content: '';
        display: block;
        top: 0;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #fbae17;
        transform-origin: 50%;
        animation: bounce-ball 500ms alternate infinite ease;
    }

    @keyframes bounce-ball {
        0% {
            top: 30px;
            height: 5px;
            border-radius: 60px 60px 20px 20px;
            transform: scaleX(2);
        }
        35% {
            height: 15px;
            border-radius: 50%;
            transform: scaleX(1);
        }
        100% {
            top: 0;
        }
    }
</style>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        if(document.querySelector('#app-loader')) document.getElementById('app-loader').style.display = 'none'
    })
</script>

