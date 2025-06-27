<?php 
namespace Classes\Abstract;
/**
 * エンティティに継承されるべき抽象クラス。
 * エンティティとは、データベース内のテーブルを表すクラスのことです。
 * 例えば「user」というエンティティは、データベース内の user テーブルと同じフィールドを持ちます。
 */
abstract class AbstractEntity
{
    /**
     * エンティティの各プロパティをバリデーションします。
     *
     * @return array エラーを含む配列
     */
    abstract public function validate():array;

    /**
     * 提供された文字列をクリーンアップし、XSS攻撃や余計なスペースを防ぎます。
     *
     * @param string $data クリーンアップするデータ
     * @return string クリーンなデータ
     */
    protected function cleanData(string $data):string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
}
