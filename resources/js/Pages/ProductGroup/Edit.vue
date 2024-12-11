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
    products: {
        type: Object,
        default: () => ({}),
    },
});

const routeGroupName = 'product_groups';
const headerTitle = ref('Product Group');


const form = useForm({
    name: props.data.name ?? '',
    active: props.data.active ?? false,  
    product_id: props.data.product_id ?? null, 
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
                                <div class="col-md-6">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name"  />
                                    <InputError :message="form.errors.name" />
                                </div>

                                <div class="col-md-6">
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
                                    <InputError :message="form.errors.product_id" />
                                </div>
                                
                                <div class="col-12">
                                    <Checkbox id="checkActive" v-model:checked="form.active">
                                        Active
                                    </Checkbox>
                                </div>
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
