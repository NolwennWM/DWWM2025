<?php 
/* 
    __DIR__ は、呼び出されたファイルが存在するディレクトリへのパスを保持する定数です。
        例：ここでは「service」フォルダへのフルパスが格納されています。

    これにより、_mailer.php がどこから require されても常に有効なパスを取得できます。

    autoload.php は、使用するすべてのライブラリを手動で require する必要をなくすオートローダーです。
    新しいクラスが使われたときに、自動的に対応するファイルを読み込もうとします。
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__."/../../vendor/autoload.php";

/**
 * メールを送信する関数
 *
 * @param string $from メールの送信者
 * @param string $to メールの受信者
 * @param string $subject メールの件名
 * @param string $body メールの本文
 * @return string 成功またはエラーメッセージ
 */
function sendMail(string $from, string $to, string $subject, string $body): string
{
    try
    {
        /* 
            新しい PHPMailer オブジェクトを作成
            "true" を渡すことで例外処理が有効になります
        */
        $mail = new PHPMailer(true);
        /* 
            SMTP を使用して接続を有効にする
            PHPMailer は SMTP（Simple Mail Transfer Protocol）を使ってメールサーバーへ接続します
        */
        $mail->isSMTP();
        /* 
            メールサーバーのアドレスを設定
            Gmail や Hotmail など任意のサーバーが使用可能です。
            ここではテスト用に "mailtrap" を使用します。
            mailtrap はテスト用にメールを捕捉し、仮想受信箱を提供してくれるサービスです。
        */
        $mail->Host = "ChangeMe";
        // SMTP認証を有効化
        $mail->SMTPAuth = true;
        // メールサーバーが使用するポート
        $mail->Port = 2525;
        // メールサーバーのユーザー名
        $mail->Username = "ChangeMe";
        $mail->Password = "ChangeMe";

        // リクエストの処理過程を詳細に表示する（デバッグ用）
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // メール送信のセキュリティを有効にする（ただし mailtrap では使用不可）
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        // 送信者情報を設定
        $mail->setFrom($from);
        // 受信者を追加
        $mail->addAddress($to);
        /* 
            以下のような他のメソッドも利用可能：
                - addReplyTo（返信先）
                - addCC（カーボンコピー）
                - addBCC（ブラインドカーボンコピー）
                - addAttachment（添付ファイル）

            isHTML を有効にすると、HTML メールとして送信されます
        */
        $mail->isHTML(true);
        // メールの件名を設定
        $mail->Subject = $subject;
        // メール本文を設定（HTML可）
        $mail->Body = $body;
        /* 
            オプションで AltBody を追加可能。
            HTML メールを受信できない環境のためのテキスト版本文です。
        */
        $mail->send();
        return "メールが送信されました";
    }
    // catch(PHPMailer\PHPMailer\Exception $error)
    catch(Exception $error)
    {
        return "メールの送信に失敗しました。エラー内容: {$error->ErrorInfo}";
    }
}

// sendMail("maurice@gmail.com", "pierre@gmail.com", "はじめてのメール", "<h1>メールを送信しました！</h1>");
