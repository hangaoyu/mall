<div id="app">
    <el-cascader
            v-model="value"
            :options="options"
            :value-key="test"
            :props="{ expandTrigger: 'hover' }"
            @change="handleChange"></el-cascader>
</div>


<script>
    new Vue({
        el: '#app',
        data() {
            return {
                test:'aa',
                value: [],
                options: [{
                    value: 'zhinan',
                    label: '指南',
                    children: [{
                        value: 'shejiyuanze',
                        label: '设计原则',
                    }, {
                        value: 'daohang',
                        label: '导航',
                    }]
                },]
            };
        },
        methods: {
            handleChange(value) {
            }
        }

    })
</script>

