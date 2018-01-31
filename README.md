# aokashi-box
[Aokashi Homeの資料集](https://contents.aokashi.net/docs/) で利用されている [Pukiwiki](https://pukiwiki.osdn.jp/) のスキンです。

[irid](https://pukiwiki.osdn.jp/?%E8%87%AA%E4%BD%9C%E3%82%B9%E3%82%AD%E3%83%B3/irid) を意識した作りで、スマートフォンの表示にも対応しています。この場合、メニューで使うサイドバーは下に配置されます。

また、CSSは [normalize.css](https://necolas.github.io/normalize.css/) で初期化していて、各要素の命名規則には [SMACSS](https://smacss.com/) を利用しています。

## 利用方法
1. このリポジトリをクローンするかダウンロードします。
2. 1.のファイルを `aokashi-box` のフォルダに入れた形で Pukiwiki の skin ディレクトリに配置します。
3. Pukiwiki の pukiwiki.ini.php のスキンファイルの参照先(`SKIN_DIR`)を `skin/aokashi-box/` に変更します。

# 仕様

## 幅によるレイアウトの調整

|幅  |レイアウト|
|----|----|
|40文字-60文字|サイドバーが下部へ移動|
|60文字-80文字|サイドバーが左側へ移動|
|80文字-|幅が80文字固定|
