<template>
    <div class="container">
        <div class="element-header row align-items-center">
            <div class="col-md-auto mr-auto">

            </div>
        </div>
        <div class="element-body">
            <div class="row component-boxes">
                <div class="col-12">
                    <div class="row component-boxes">
                        <div class="col-12">
                            <div class="component-box box-white">
                                <div class="component-box-inner">
                                    <div class="component-box-profile">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Users</label><br/>
                                                    <select class="form-control" v-model="selected_user">
                                                        <option v-for="user in users" v-bind:value="user.id">
                                                            {{user.full_name}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Products</label><br/>
                                                    <select class="form-control" @change="changeProducts"
                                                            v-model="selected_product">
                                                        <option v-for="product in products" v-bind:value="product.id">
                                                            {{product.name}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Quantity</label><br/>
                                                    <select class="form-control" @change="changeQuantity"
                                                            v-model="selected_quantity">
                                                        <option v-for="cou_product in count_products"
                                                                v-bind:value="cou_product">
                                                            {{cou_product}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Price</label><br/>
                                                    <span v-model="product_price">{{ product_price }}</span> EUR
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Total</label><br/>
                                                    <span v-model="total">{{ total }}</span> EUR <span style="color:red;" v-if="discount"> -20% Discount</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <button class="btn btn-secondary" @click="store">add order</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="component-box box-white" style="margin-top: 20px;">
                        <div class="component-box-inner">
                            <div class="component-box-profile">
                                <div class="user-profile-layout">
                                    <div class="responsive">
                                        <div class="row mt-2 mb-2">
                                            <div class="col-md-7">
                                                <div class="form-row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Search Period</label><br/>
                                                            <select class="form-control" @change="fetchOrders"
                                                                    v-model="search_type">
                                                                <option v-for="serach_type in count_search_types"
                                                                        v-bind:value="serach_type.type">
                                                                    {{serach_type.name}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Search</label><br/>
                                                            <input type="text" v-model="search_orders" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label><br/>
                                                            <button class="btn btn-success" @click="fetchOrders">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <app-orders v-for="(order, index) in orders"
                                                            :index="index"
                                                            :order="order"
                                                            :key="order.id"
                                                            @removeOrder="removeOrder"></app-orders>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import appOrders from './TableRow';
    import appMultiselect from 'vue-multiselect';

    export default {
        data() {
            return {
                orders: [],
                filter_term: '',
                form: {},
                users: [],
                products: [],
                selected_user: {},
                selected_product: {},
                count_products: [1, 2, 3, 4, 5],
                selected_quantity: 0,
                product_price: 0,
                total: 0,
                isValid: false,
                search_type: 1,
                count_search_types: [
                    {name: 'All', 'type': 1},
                    {name: 'Last 7 days', 'type': 2},
                    {name: 'Today', 'type': 3}
                ],
                search_orders: '',
                discount: false
            };
        },
        computed: {},
        methods: {
            fetchOrders() {
                if(this.search_orders == ''){
                    axios.get('/orders/' + this.search_type).then(res => {
                        this.orders = res.data;
                    }).catch(error => console.log(error));
                }else{
                    axios.get('/orders/' + this.search_type + '/'+this.search_orders).then(res => {
                        this.orders = res.data;
                    }).catch(error => console.log(error));
                }
            },
            removeOrder(index) {
                this.orders.splice(index, 1);
            },
            fetchUsers() {
                axios.get('/admin/users').then(res => {
                    this.users = res.data;
                }).catch(error => console.log(error));
            },
            fetchProducts() {
                axios.get('/admin/products').then(res => {
                    this.products = res.data;
                }).catch(error => console.log(error));
            },
            changeProducts() {
                axios.get('/admin/product/' + this.selected_product + '/show').then(res => {
                    console.log(res.data);
                    this.selected_product = res.data.id;
                    this.product_price = res.data.price;
                    this.selected_quantity = 1;
                    this.calculateSum();
                }).catch(error => console.log(error));
            },
            changeQuantity() {
                this.calculateSum();
            },
            calculateSum() {
                this.discount = false;
                let Sumtotal = this.product_price * this.selected_quantity;
                if(this.selected_quantity >= 3){
                    Sumtotal -= Sumtotal/100*20;
                    this.discount = true;
                }
                this.total = Sumtotal.toFixed(2);
            },
            store() {
                if (this.total > 0 && this.selected_user > 0) {
                    this.prepareForm();
                    axios.post('/order/store', this.form).then(res => {
                        this.$toastr.s(this.$t("saved"));
                        location.reload();
                    }).catch(error => console.log(error));
                } else {
                    this.$toastr.e("validation error");
                }

            },
            prepareForm() {
                this.form = {
                    user_id: this.selected_user,
                    product_id: this.selected_product,
                    product_price: this.product_price,
                    product_count: this.selected_quantity,
                    order_sum: this.total
                }
            }
        },
        components: {
            appOrders,
            appMultiselect
        },
        created() {
            this.fetchOrders();
            this.fetchUsers();
            this.fetchProducts();
        }
    }
</script>
