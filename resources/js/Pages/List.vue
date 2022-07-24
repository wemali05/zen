<template>
    <div class="container my-5">
        <div v-if="resources.length > 0" class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>List Resources</h1>
                    <a href="/resources/create ">Create Resource</a>
                </div>
                <div class="card mb-4" v-for="(resource, index) in resources" :key="index">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex">
                                <p class="m-0">{{ resource.pdf_title }}</p>
                                <a :href="resource.pdf_path" target="_blank" :download="resource.pdf_name" class="m-0 px-4 align-items-center">download pdf</a>
                            </div>
                            <div class="d-flex align-items-center">
                                <Link class="btn btn-primary mr-4" :href="route('resources.edit', resource.id)">Edit</Link>
                                <button class="btn btn-danger" @click="deleteResource(resource.id)">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="m-0">{{ resource.snippet_title }}</h4>
                            <div class="mt-4 d-flex justify-content-between align-items-start ">
                                <p class="m-0" ref="snippet" v-html="resource.snippet_content"></p>
                                <button type="submit" class="btn btn-primary text-nowrap ml-5" @click.prevent="copy">Copy snippet</button>
                                <input type="hidden" id="copy-snippet" :value="resource.snippet_content">
                            </div>
                        </div>
                        <div class="">
                            <h4 class="m-0">{{ resource.snippet_title }}</h4>
                            <a v-if="resource.open_tab" :href="resource.link" target="_blank" class="m-0 text-decoration-none">{{ resource.link }}</a>
                            <a v-else :href="resource.link" class="m-0 text-decoration-none">{{ resource.link }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="mt-4 d-flex justify-content-between align-items-center">
            <h4>No resources submitted</h4>
            <a href="/resources/create ">Create Resource</a>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import axios from 'axios'

export default {
    name: 'List',

    components: { Link },

    props: {
        resources: {
            type: Array,
            required: true
        }
    },

    data: function () {
        return {
            loading: false
        }
    },

    methods: {
        copy() {
            let snippetToCopy = document.querySelector('#copy-snippet')
            snippetToCopy.setAttribute('type', 'text')
            snippetToCopy.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                alert('Testing code was copied ' + msg);
            } catch (err) {
                alert('Oops, unable to copy');
            }

            /* unselect the range */
            snippetToCopy.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },

        deleteResource: function(id) {
            this.loading = true
            axios.delete(route('resources.destroy', id))
                .then(() => {
                    this.loading = false
                    this.$inertia.reload()
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
    }
}
</script>
