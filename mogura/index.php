<!DOCTYPE html>
<html lang='ja'>
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<META http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<meta name="description" content="">
	<link rel='apple-touch-icon' href='apple-touch-icon.png'>
	<link rel='icon' href='favicon.ico'>
	<!-- Bootstrap5 CSS/js -->
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
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
			transform: translateY(100%);	
		  /*position: absolute;
			left:0;
		  bottom: 0;*/
		
		  /* アニメーションの設定 */
		  animation: slideUp 3s ease-in-out 2 alternate; 
		}
		
		@keyframes slideUp {
		  0% {
			transform: translateY(100%); /* 初期位置：divの枠外（下） */
		  }
		  100% {
			transform: translateY(0);    /* 開始位置：本来の表示位置（上） */
		  }
		}
		.btn{
			width: 150px;
		}
		body{
			touch-action: manipulation
		}
	</style>
</head>
<body>
	<div class="container" id="app">
		<div class="row">
			<div class="col-12 pt-5 pb-3 text-center bg-success-subtle text-success-emphasis">
				<!--ボタンを作ろう-->
				<button class="btn btn-primary mb-3" @click='もぐら出現'>モグラ出現</button><br>
				<button class="btn btn-primary mb-3" @click='スタート'>スタート</button>
				<input type="number" class="form-control" v-model="プレイタイム">
				<p>{{スコア}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12 pt-5 text-center">
				<div class='' style="width:100%;height:100px;" id="芝生">
				</div>
			</div>
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
			#default_sec = Number(5)
			constructor(Level){
				this.難易度 = Level
			}

			もぐ出現 = (id) =>{	//id=モグラナンバー
				//console.log("もぐ出現　動いたよ！")
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
				  <div class="crop-box" id="${id}" 
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
							data-value = "${点}"
						>
				  </div>
				`);

				//モグラを消す
				setTimeout(() => {
  			  const element = document.getElementById(id);
  			  if (element) {
  			    element.remove();
  			  }
  			}, 速度 * 2 * 1000); // setTimeoutはミリ秒単位なので1000倍する
			}
		}

		class モグラ台設計図{
			#score = 0
			芝生
			constructor(id){
				this.芝生 = document.getElementById(id)
			}

			ハンマー = (callback) =>{
				console.log(this.芝生)
				this.芝生.addEventListener('click',(event)=>{
					if(event.target.dataset.value){
						this.#score = this.#score + Number(event.target.dataset.value)
						console.log(this.#score)
						callback(this.#score)
					}else{
						console.log("not もぐら")
					}
				})
			}

		}
		const { createApp, ref,reactive,shallowRef, onMounted, onBeforeMount, computed, VueCookies,watch,nextTick } = Vue;
		createApp({
			setup(){
				const もぐら製造機 = new もぐら製造機設計図(1)
				const もぐら出現 = () =>{
					もぐら製造機.もぐ出現(3)
				}
				const プレイタイム = ref(60)
				const スコア = ref(0)

				const スコア更新 = (newScore) =>{
					console.log("callback")
					スコア.value = newScore
				}
				// 指定時間（ミリ秒）待機するためのヘルパー関数
				const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

				const スタート = async() =>{
					スコア.value = 0	//0点からスタート
					let counter = 0
					while (プレイタイム.value > counter){
						//0.5秒～1秒間隔で実行
						let 間隔 = getRandomInt(1,10) * 100
						もぐら製造機.もぐ出現(counter)
						await sleep(間隔)

						//console.log(`counter:${counter}`)
						counter ++;
					}
					console.log("おわり")
				}

				onMounted(()=>{
					console.log('onMounted')
					const もぐら台 = new モグラ台設計図("芝生")
					もぐら台.ハンマー(スコア更新)
				})

				return{//リターン
					もぐら出現,
					プレイタイム,
					スタート,
					スコア,
				}
			}
		}).mount('#app');
		</script>
</body>
</html>	
