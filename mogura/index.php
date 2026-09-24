<!DOCTYPE html>
<html lang='ja'>
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<META http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta name="description" content="">
	<link rel='apple-touch-icon' href='apple-touch-icon.png'>
	<link rel='icon' href='favicon.ico'>
	<!-- Bootstrap5 CSS/js -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<!--Vue.js-->
	<script src="https://cdn.jsdelivr.net/npm/vue@3.4.4"></script>
	<script src="https://unpkg.com/vue-cookies@1.8.2/vue-cookies.js"></script>
	<!--ajaxライブラリ-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
	<script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
	<TITLE>ユメノが作ったよ</TITLE>
	<style>
		.crop-box {
		  width: 50px;             /* 任意の横幅 */
		  height: 50px;            /* 任意の高さ */
		  overflow: hidden;         /* はみ出た部分を隠す */
		  position: fixed;       /* 位置指定の基準 */
			/*top:333px;
			left:333px;*/
		}
		
		.crop-box img {
		  width: 100%;              /* 横幅をdivに合わせる */
		  height: auto;             /* 縦横比を維持 */
			mix-blend-mode: multiply; /* 乗算処理で白い部分を透過（暗い部分のみ残る） */
		  /*position: absolute;
			left:0;
		  bottom: 0;*/
		
		  /* アニメーションの設定 */
		  animation: slideUp 3s linear infinite alternate; 
		}
		
		@keyframes slideUp {
		  0% {
			transform: translateY(100%); /* 初期位置：divの枠外（下） */
		  }
		  100% {
			transform: translateY(0);    /* 開始位置：本来の表示位置（上） */
		  }
		}
	</style>
</head>
<body style='width:100%;text-align:center;'>
	<div class="container" id="app">
		<!--<div class='bg-success' style="position:fixed;top:100px;left:100px;width:600px;height:600px;" id="芝生">-->
		<div class='pt-5 text-center' style="width:100%;height:100%;" id="芝生">
			<button class="btn btn-primary" @click='もぐら出現'>もぐら出現</button>
		</div>
	</div>
	<script>
		/**
		* 指定した範囲（下限値〜上限値）のランダムな整数を返す関数
		* @param {number} min - 下限値（この値を含む）
		* @param {number} max - 上限値（この値を含む）
		* @returns {number} 範囲内のランダムな整数
		*/
		const getRandomInt = (min, max) => {
		  return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		class もぐら製造機設計図{
			#default_size = Number(100)
			#default_sec = Number(1.5)
			constructor(Level){
				this.難易度 = Level
			}

			もぐ出現 = () =>{
				console.log("もぐ出現　動いたよ！")
				let 横幅 = window.innerWidth	//画面の横幅
				let 縦幅 = window.innerHeight	//画面のたて幅
				let 座標X = getRandomInt(100,Number(横幅) - 100)
				let 座標Y = getRandomInt(100,Number(縦幅) - 100)
				let 点 = Number(getRandomInt(1,5))	//max 5点
				let サイズ = this.#default_size
				let 速度 = this.#default_sec

				let buf = getRandomInt(1,2)	//1:サイズ　2:速さ
				if(buf === 1){
					サイズ = サイズ / 点;
				}else if(buf === 2){
					速度 = 速度 / 点;
				}

				const container = document.getElementById("芝生"); // 追加したい親要素
				container.insertAdjacentHTML('beforeend', `
				  <div class="crop-box" 
					style = "
						top:${座標Y}px;
						left:${座標X}px;
						width:${サイズ}px;
						height:${サイズ}px;
						">
						<img src="もぐら.png" alt="もぐら" role="button"
							style = "
								animation-duration: ${速度}s;
								"
							@click="point(${点})"
						>
				  </div>
				`);
			}
		}
		const { createApp, ref,reactive,shallowRef, onMounted, onBeforeMount, computed, VueCookies,watch,nextTick } = Vue;
		createApp({
			setup(){
				const もぐら製造機 = new もぐら製造機設計図(1)
				const もぐら出現 = () =>{
					もぐら製造機.もぐ出現(3)
				}
				


				onMounted(()=>{
					console.log('onMounted')
					window.addEventListener('resize', handleResize);
				})

				return{//リターン
					もぐら出現,
				}
			}
		}).mount('#app');
		</script>
</body>
</html>	
