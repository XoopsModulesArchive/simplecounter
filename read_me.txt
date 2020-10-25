簡単なカウンターです。
テキストカウンター、画像カウンターが入っています。
xoops2でのみ確認しています。

使っている場合は、是非
http://xoops-modules.sourceforge.jp/modules/xhnewbb/
でカミングアウトしてください。

■重要
xoops-module project では、register_globals = Offで運用を強く推奨します。
register_globals = Offにする設定は以下のスレッドをご覧ください。
http://jp.xoops.org/modules/xhnewbb/viewtopic.php?viewmode=flat&topic_id=3018&forum=17

■連絡先
	http://xoops-modules.sourceforge.jp/ 
	http://sourceforge.jp/projects/xoops-modules/   (意見・要望・バグレポートはこちら)
	
■インストール
	$xoops_home/modulesにsimplecounterフォルダをコピーしてください。

■画像カウンター
	1.2から画像カウンターも入っています。画像がダサイので変更したい方はimagesフォルダの画像を差し替えて下さい.

■1.2から1.2.1へのアップデート
	1.2.1はインストール時のバグフィックスバージョンです。
	管理画面で日付毎のアクセスが表示される方はアップデートする必要はないですし、
	以下の手順は実行しないでください。
	
	管理画面で日付毎が表示されない方は、
	「1.1.3以前から1.2/1.2.1へのアップデート」
	を実行し、
	<プレフィックス>_xoops_simplecounter_total
	テーブルを削除してください。
	
■1.1.3以前から1.2/1.2.1へのアップデート
	管理者権限でxoopsにログインした後、
	http://<XOOPS_URL>/modules/simplecounter/admin/update_before_1_1_3_to_1_2.php
	にブラウザでアクセスしてください。
■1.2.1から1.2.2へのアップデート
	サイトをメンテナンスモードにし、XOOPS_ROOT_PATH/modules/simplecounterディレクトリを
	削除し、1.2.2をXOOPS_ROOT_PATH/modules/simplecounterにアップロードしてください。


$Id: read_me.txt,v 1.2 2006/03/29 03:08:55 mikhail Exp $

