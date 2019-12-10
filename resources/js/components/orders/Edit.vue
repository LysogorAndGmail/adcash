<style>
    .multiselect__tags input {
        width: 100% !important;
    }
</style>
<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ $t("edit") }}</h2>
                </div>
            </div>
            <div class="element-body">
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
                                                <select class="form-control" @change="changeQuantity" v-model="selected_quantity">
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
                                                <span v-model="total">{{ total }}</span> EUR
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <button class="btn btn-secondary" @click="update">{{ $t("update") }}
                                        </button>
                                        <router-link
                                                :to="{name: 'order.edit', params:{order_id: $route.params.order_id}}"
                                                tag="button" class="btn btn-warning">
                                            {{ $t("cancel") }}
                                        </router-link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import appMultiselect from 'vue-multiselect';

    export default {
        data() {
            return {
                form: {},
                users: [],
                products: [],
                selected_user: {},
                selected_product: {},
                count_products: [1, 2, 3, 4, 5],
                selected_quantity: 0,
                product_price: 0,
                total: 0
            }
        },
        methods: {
            fetchOrder() {
                axios.get('/order/' + this.$route.params.order_id + '/show').then(res => {
                    this.form = res.data;
                    this.selected_user = res.data.order_user.id;
                    this.selected_product = res.data.order_product.id;
                    this.selected_quantity = res.data.product_count;
                    this.product_price = res.data.product_price;
                    this.total = res.data.order_sum;
                }).catch(error => console.log(error));
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
                axios.get('/admin/product/'+this.selected_product+'/show').then(res => {
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
            calculateSum(){
                let Sumtotal = this.product_price * this.selected_quantity;
                this.total = Sumtotal.toFixed(2);
            },
            update() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        this.prepareForm();
                        axios.put('/order/' + this.$route.params.order_id + '/update', this.form).then(res => {
                            this.$toastr.s(this.$t("updated"));
                            this.$router.push({
                                name: 'dashboard'
                            });
                        }).catch(error => console.log(error));
                    }
                });
            },
            prepareForm() {
                this.form = {
                    user_id: this.selected_user,
                    product_id: this.selected_product,
                    product_price: this.product_price,
                    product_count: this.selected_quantity,
                    order_sum: this.total
                }
            },
        },
        components: {
            appMultiselect
        },
        created() {
            this.fetchUsers();
            this.fetchProducts();
            this.fetchOrder();
        }
    }
</script>
