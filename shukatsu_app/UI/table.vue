<script src="vue.js"></script>
<template>
    <div id="app">
        <div class="buttons">
            <div class="addbutton">
                <form action="" method="post">
                    <button type="submit" name="add">リロード</button>
                </form>
            </div>
            <div class="display_choice">
                <select name="display_choice" id="display_choice">
                    <option value="0">すべてを表示</option>
                    <option value="1">気になる</option>
                    <option value="2">選考中</option>
                    <option value="3">内定</option>
                </select>
            </div>
        </div>
        <table width="100%">
            <thead>
                <tr>
                    <th>会社名</th>
                    <th>☆</th>
                    <th colspan="2">ES</th>
                    <th colspan="3">テスト</th>
                    <th colspan="2" v-for="(company, index) in companies" key="company">{{ index+1 }}次面接</th>
                    <th>結果</th>
                </tr> 
            </thead>
            <tbody>
                <div class="company">
                    <tr><td>sample</td></tr>
                    <tr><td>sample</td></tr>
                </div>
            </tbody>
        </table>
    </div>
</template>

<script>
export default{
    name: 'makeTable',
}
</script>
