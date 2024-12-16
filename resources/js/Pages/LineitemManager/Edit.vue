<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    products:{
        type: Array
    },
    productGroups: {
        type: Array
    },
    modules:{
        type: Array
    },
    columns: {
        type: Array
    }
});

const routeGroupName = 'lineitem_managers';
const headerTitle = ref('Line Item Manager');

const form = useForm({
    module: props.data.module ?? null,
    product_id: props.data.product_id ?? null,
    product_group_id: props.data.product_group_id ?? null,
    suite: props.data.product_group_id ?? null,
    active: props.data.active,
    attributes: props.data.attributes ?? [],
});

</script>

<template>
    <Head :title="headerTitle" />

    <AuthenticatedLayout>
        <template #header>
            {{ headerTitle }} 
        </template>

        <form @submit.prevent="data.id == null ? form.post(route(routeGroupName + '.store')) : form.patch(route(routeGroupName + '.update', data.id))">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1">Details</a>
                        </li>
                       
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade pt-10 show active" id="tab_1" role="tabpanel" aria-labelledby="tab_1">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <InputLabel for="product_id" value="Product" />
                                    <select
                                        id="product_id"
                                        v-model="form.product_id"
                                        class="form-select"
                                        :invalid="form.errors.product_id"
                                        required
                                    >
                                        <option :value=null>Select Product</option>
                                        <option
                                            v-for="(name, id) in products"
                                            :key="id"
                                            :value="id"
                                        >
                                            {{ name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="product_group_id" value="Product Group" />
                                    <select
                                        id="product_group_id"
                                        v-model="form.product_group_id"
                                        class="form-select"
                                        :invalid="form.errors.product_group_id"
                                        required
                                    >
                                        <option :value=null>Select Product Group</option>
                                        <option
                                            v-for="(name, id) in productGroups"
                                            :key="id"
                                            :value="id"
                                        >
                                            {{ name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="suite" value="Suite" />
                                    <select
                                        id="suite"
                                        v-model="form.suite"
                                        class="form-select"
                                        :invalid="form.errors.suite"
                                        required
                                    >
                                        <option :value=null>Select Product Group</option>
                                        <option
                                            v-for="(name, id) in productGroups"
                                            :key="id"
                                            :value="id"
                                        >
                                            {{ name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="module" value="Module" />
                                    <select
                                        id="module"
                                        v-model="form.module"
                                        class="form-select"
                                        :invalid="form.errors.module"
                                        required
                                    >
                                        <option :value=null>Select Module</option>
                                        <option
                                            v-for="name in modules"
                                            :key="name"
                                            :value="name"
                                        >
                                            {{ name }}
                                        </option>
                                    </select>
                                </div>
                                <!-- <div class="col-md-6">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name" required />
                                    <InputError :message="form.errors.name" />
                                </div> -->
                                
                                <!-- <div class="col-12">
                                    <Checkbox id="checkActive" v-model:checked="form.active">
                                        Active
                                    </Checkbox>
                                </div> -->

                            </div>

                            <div class="row g-3 mt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="3%">No</th>
                                            <th width="3%">Active</th>
                                            <th width="10%">Symbol</th>
                                            <th width="20%">Attribute</th>
                                            <th>Expression</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in columns" :key="index">
                                            <td class="text-center">{{ index + 1 }}</td>
                                            <td class="text-center"><Checkbox id="checkActive"></Checkbox></td>
                                            <td><TextInput type="text"/></td>
                                            <td>{{ row }}</td>
                                            <td>
                                                <TextInput type="text"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12">
                        <Link class="btn btn-secondary me-2" :href="route(routeGroupName + '.index')">Back</Link>
                        <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'" :disabled="form.processing"></PrimaryButton>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>