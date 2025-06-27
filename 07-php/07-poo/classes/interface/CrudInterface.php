<?php 
namespace Classes\Interface;

/**
 * CRUD 用のクラスであることを示すインターフェース。
 * 各 CRUD 操作（作成・読み取り・更新・削除）に対応する関数を持つ必要があります。
 */
interface CrudInterface
{
    function create();   // 作成
    function read();     // 読み取り
    function update();   // 更新
    function delete();   // 削除
}
