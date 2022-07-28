<template>
    <div class="container my-5">
        <loading v-if="loading" :active.sync="loading" color="#32489e" loader="spinner"/>
        <div v-else class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Edit Resource</h1>
                    <a href="/resources">View all resources</a>
                </div>
                <form class="mt-5" @submit.prevent="editForm">
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="pdf_title">Pdf title</label>
                            <input type="text" id="pdf_title" v-model="form.pdf_title"  class="form-control"  placeholder="Pdf title" required>
                        </div>
                        <div class="form-group mb-3">
                            <div class="">
                                <label for="pdf_title">Upload pdf</label>
                            </div>
                            <input type="file" @change="onChange" name="pdf_file" ref="pdf" id="customFile" required >
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="snippet_title">Snippet title</label>
                            <input type="text" class="form-control" id="snippet_title" v-model="form.snippet_title" placeholder="snippet title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="snippet_content">Snippet content</label>
                            <QuillEditor :options="editorOption"
                                         v-model:content="form.snippet_content"
                                         content="string"
                                         content-type="html"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="link_title">Link title</label>
                            <input type="text" class="form-control" id="link_title" v-model="form.link_title" placeholder="Link title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="link">LinK</label>
                            <input type="text" class="form-control" id="link" v-model="form.link" placeholder="Link" required>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" v-model="form.open_tab" class="custom-control-input mr-2" id="tab">
                            <label class="custom-control-label" for="tab">Open in a new tab</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { QuillEditor } from '@vueup/vue-quill'
import Loading from 'vue-loading-overlay';

export default {
    name: 'Edit',

    components: {
        QuillEditor,
        Loading
    },

    props: {
        resource: {
            type: Object,
            required: true
        },

    },

    data: function () {
        return {
            loading: false,
            file: '',
            form : {
                pdf_title: this.resource.pdf_title,
                snippet_title: this.resource.snippet_title,
                snippet_content: this.resource.snippet_content,
                link_title: this.resource.link_title,
                link: this.resource.link,
                open_tab: this.resource.open_tab
            },
            editorOption: {
                theme: 'snow',
                placeholder: 'Add snippet...',
                modules: {
                    clipboard: {
                        allowed: {
                            tags: ['h1', 'h2', 'h3', 'p', 'a', 'b', 'strong', 'u', 's', 'i', 'br', 'ul', 'ol', 'li', 'span', 'blockquote'],
                            attributes: ['href', 'rel', 'target', 'class']
                        },
                        keepSelection: true,
                        substituteBlockElements: true,
                        magicPasteLinks: true,
                    },
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'color': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link']
                    ],
                }
            },
        }
    },

    methods: {
        onChange(e) {
            this.file = e.target.files[0];
        },

        editForm: function () {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            // form data
            const formData = new FormData();
            formData.append('file', this.file)
            formData.append('pdf_title', this.form.pdf_title)
            formData.append('snippet_title', this.form.snippet_title)
            formData.append('snippet_content', this.form.snippet_content)
            formData.append('link_title', this.form.link_title)
            formData.append('link', this.form.link)
            formData.append('open_tab', this.form.open_tab)

            // this.loading = true
            axios.put(route('resources.update', this.resource.id), formData, config)
                .then(() => {
                    // this.loading = false
                })
                .catch(error => {
                    console.log(error.response)
                });
        }
    }

}
</script>
