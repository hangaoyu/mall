<style>

    hr {
        display: none;
    }
</style>
<div class="form-group">
    <label for="service_ids" class="col-sm-2  control-label">选择优惠方式</label>
    <div id="app" class="col-sm-8">
        <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="无优惠" name="first"></el-tab-pane>
        <el-tab-pane label="特惠促销" name="second">
            <div class="form-group  col-sm-offset-4 col-sm-8 ">
                <label class="col-sm-3 control-label">开始时间:</label>
                <el-date-picker
                        v-model="start_time"
                        type="datetime"
                        placeholder="选择日期时间">
                </el-date-picker>
            </div>
            <div class="form-group  col-sm-offset-4 col-sm-8 ">
                <label class="col-sm-3  control-label">结束时间:</label>
                <el-date-picker
                        v-model="end_time"
                        type="datetime"
                        placeholder="选择日期时间">
                </el-date-picker>
            </div>

            <div class="col-sm-10">
                <label class="col-sm-2  control-label">促销价格</label>
                <div class="input-group">
                    <span class="input-group-addon">元</span>
                    <input style="width: 120px; text-align: right;" type="text" id="price" name="price" value=""
                           class="form-control price" placeholder="输入 商品售价">
                </div>
            </div>
        </el-tab-pane>
        <el-tab-pane label="会员价格" name="third">
            <div class="form-group  col-sm-offset-4 col-sm-8 ">
                <label class="col-sm-3  control-label">黄金会员</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">元</span>
                        <input style="width: 120px; text-align: right;" type="text" id="price" name="price" value=""
                               class="form-control price" placeholder="输入 商品售价">
                    </div>
                </div>
            </div>
            <div class="form-group  col-sm-offset-4 col-sm-8 ">
                <label class="col-sm-3  control-label">白金会员</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">元</span>
                        <input style="width: 120px; text-align: right;" type="text" id="price" name="price" value=""
                               class="form-control price" placeholder="输入 商品售价">
                    </div>
                </div>
            </div>
            <div class="form-group  col-sm-offset-4 col-sm-8 ">
                <label class="col-sm-3  control-label">钻石会员</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">元</span>
                        <input style="width: 120px; text-align: right;" type="text" id="price" name="price" value=""
                               class="form-control price" placeholder="输入 商品售价">
                    </div>
                </div>
            </div>
        </el-tab-pane>
        <el-tab-pane label="阶梯价格" name="fourth"></el-tab-pane>
        <el-tab-pane label="满减价格" name="fifth"></el-tab-pane>
        </el-tabs>
    </div>

</div>
<script>
    $(function () {
        $("#has-many-ladders").css("display", "none");
        $("#has-many-fullreduces").css("display", "none");
        $("#has-many-fullreduces").css("margin-top", "0px");
    })
    new Vue({
        el: '#app',
        data() {
            return {
                start_time: '',
                end_time: '',
                activeName: 'first'
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log('aa');
                if (tab.name == 'fourth') {

                    $("#has-many-ladders").css("display", "block");
                } else {
                    $("#has-many-ladders").css("display", "none");
                }
                if (tab.name == 'fifth') {
                    $("#has-many-fullreduces").css("display", "block");
                } else {
                    $("#has-many-fullreduces").css("display", "none");
                }

            }
        },

    });
</script>