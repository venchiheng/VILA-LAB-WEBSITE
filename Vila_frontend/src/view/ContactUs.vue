<template>
    <div class="container">
        <div class="form-section">
            <!-- Contact Info -->
            <div class="contact">
                <h2 style="text-align: left; margin-bottom: 10px;">Get in Touch with Us</h2>
                <p style="text-align: left; margin-bottom: 20px;">Connect with us for inquiries, support, or collaboration</p>
                <div class="icon-group">
                    <div class="icon-text">
                        <Icon icon="solar:user-bold" class="icon" />
                        <span>
                            <a href="/aboutlab">Dr. VALY Dona, Head of ViLa Laboratory</a>
                        </span>
                    </div>
                    <div class="icon-text">
                        <Icon icon="line-md:phone-call" class="icon" />
                        <span>
                            <a href="tel:+85512702639">+(855) 12 702 639</a>
                        </span>
                    </div>

                    <div class="icon-text">
                        <Icon icon="line-md:email" class="icon" />
                        <span>
                            <a href="mailto:dona@itc.edu.kh">dona@itc.edu.kh</a>
                        </span>
                    </div>

                    <div class="icon-text">
                        <Icon icon="ic:baseline-facebook" class="icon" />
                        <span>
                            <a href="https://www.facebook.com/vilalabitc" target="_blank">
                                https://www.facebook.com/vilalabitc
                            </a>
                        </span>
                    </div>
                </div>

                <!-- Google Map -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.7339877710547!2d104.89524781102118!3d11.570917743988755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310951290d128633%3A0x13457ed11b10b8a!2sViLa%20Lab!5e0!3m2!1sen!2skh!4v1767255378087!5m2!1sen!2skh"
                    width="100%" height="350" style="border: 0; margin-top: 20px;" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Contact Form -->
            <div class="form">
                <v-form>
                    <div class="full">
                        <input type="text" placeholder="Full Name" v-model="formData.message_fullname"
                            :class="{ 'error-input': errors.message_fullname }" @input="errors.message_fullname = ''" />
                        <span v-if="errors.message_fullname" class="error-text">
                            {{ errors.message_fullname }}
                        </span>
                    </div>

                    <div class="full">
                        <input type="text" placeholder="Email Address" v-model="formData.message_email"
                            :class="{ 'error-input': errors.message_email }" @input="errors.message_email = ''" />
                        <span v-if="errors.message_email" class="error-text">
                            {{ errors.message_email }}
                        </span>
                    </div>

                    <div class="full">
                        <input type="text" placeholder="Phone Number" v-model="formData.message_phNum"
                            :class="{ 'error-input': errors.message_phNum }" @input="errors.message_phNum = ''" />
                        <span v-if="errors.message_phNum" class="error-text">
                            {{ errors.message_phNum }}
                        </span>
                    </div>

                    <div class="full">
                        <textarea class="full-purpose" placeholder="Your Message" v-model="formData.message_detail"
                            :class="{ 'error-input': errors.message_detail }"
                            @input="errors.message_detail = ''"></textarea>
                        <span v-if="errors.message_detail" class="error-text">
                            {{ errors.message_detail }}
                        </span>
                    </div>

                    <p>
                        By clicking the submit button below, I hereby agree to and accept the following
                        <router-link to="/terms-of-use-and-privacy-policy"
                            style="color: #3758F9; text-decoration: none">
                            Terms and Conditions
                        </router-link>.
                    </p>

                    <div class="btnCont">
                        <button type="button" @click="submitForm">
                            Send Message
                        </button>
                    </div>
                </v-form>
            </div>
        </div>
    </div>

    <!-- Snackbar -->
    <v-snackbar v-model="snackbar.show" :color="snackbar.color" timeout="3000">
        {{ snackbar.message }}
    </v-snackbar>

    <!-- Loading Overlay -->
    <v-overlay :model-value="isLoading" class="d-flex align-center justify-center" persistent>
        <v-progress-circular indeterminate size="64" color="primary" />
    </v-overlay>
</template>

<script>
import { Icon } from '@iconify/vue'
import { useContactMessageStore } from '../stores/contact_message';

export default {
    name: 'VisitForm',

    components: { Icon },

    data() {
        return {
            isLoading: false,
            snackbar: {
                show: false,
                color: 'success',
                message: ''
            },
            formData: {
                message_fullname: '',
                message_email: '',
                message_phNum: '',
                message_detail: ''
            },
            errors: {
                message_fullname: '',
                message_email: '',
                message_phNum: '',
                message_detail: ''
            }
        }
    },

    methods: {
        validateForm() {
            let valid = true
            Object.keys(this.errors).forEach(key => (this.errors[key] = ''))

            if (!this.formData.message_fullname) {
                this.errors.message_fullname = 'Full name is required'
                valid = false
            } else if (this.formData.message_fullname.length < 3) {
                this.errors.message_fullname = 'Full name must be at least 3 characters'
                valid = false
            }

            if (!this.formData.message_email) {
                this.errors.message_email = 'Email is required'
                valid = false
            } else if (!/.+@.+\..+/.test(this.formData.message_email)) {
                this.errors.message_email = 'Email must be valid'
                valid = false
            }

            if (!this.formData.message_phNum) {
                this.errors.message_phNum = 'Phone number is required'
                valid = false
            } else if (!/^\d{8,15}$/.test(this.formData.message_phNum)) {
                this.errors.message_phNum = 'Enter a valid phone number'
                valid = false
            }

            if (!this.formData.message_detail) {
                this.errors.message_detail = 'Message is required'
                valid = false
            }

            return valid
        },

        async submitForm() {
            if (!this.validateForm()) return

            this.isLoading = true
            const store = useContactMessageStore()

            try {
                await store.postMessage({ ...this.formData })
                this.showSnackbar('Message sent successfully', 'success')
                this.resetForm()
                console.log('Message sent:', this.formData)
            } catch (error) {
                console.error(error)
                this.showSnackbar('Failed to send message', 'error')
            } finally {
                this.isLoading = false
            }
        },

        resetForm() {
            Object.keys(this.formData).forEach(key => (this.formData[key] = ''))
            Object.keys(this.errors).forEach(key => (this.errors[key] = ''))
        },

        showSnackbar(message, color) {
            this.snackbar = { show: true, color, message }
        }
    }
}
</script>

<style scoped>
.container {
    width: 100%;
}

.form-section {
    display: flex;
    gap: 40px;
    padding-inline: 133px;
    margin-top: 40px;
    margin-bottom: 100px;
    align-items: stretch; 
}

.contact,
.form {
    flex: 1 1 50%;
    max-width: 50%;
    box-sizing: border-box; 
}

.form {
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.07);
    border-radius: 8px;
    padding: 40px;
    text-align: left;
}

.full {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}

.full-purpose {
    padding: 12px 20px;
    height: 130px;
    border: 1px solid rgba(223, 228, 234, 1);
    border-radius: 6px;
}

input {
    padding: 12px 20px;
    border: 1px solid rgba(223, 228, 234, 1);
    border-radius: 6px;
}

button {
    background-color: #3457D5;
    color: white;
    padding: 12px;
    border-radius: 50px;
    width: 100%;
    font-weight: 600;
    transition: background-color 0.3s;
    margin-top: 20px;
}

button:hover {
    background-color: #2335ff;
}

.error-input {
    border: 1px solid red;
}

.error-text {
    color: red;
    font-size: 13px;
    margin-top: 2px;
}

.icon {
    width: 48px;
    height: 48px;
    padding: 13px;
    border-radius: 100px;
    background-color: var(--color-secondary);
    color: var(--color-text);
}

.icon-group {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.icon-text {
    display: flex;
    align-items: center;
    text-align: left;
    gap: 16px;
}

@media (max-width: 1024px) {
    .form-section {
        flex-direction: column;
        padding-inline: 20px;
        gap: 30px;
    }

    .contact,
    .form {
        flex: 1 1 100%;
        max-width: 100%;
    }

    .form {
        padding: 30px;
    }
}

@media (max-width: 600px) {
    .form-section {
        padding-inline: 10px;
        gap: 20px;
    }

    .form {
        padding: 20px;
    }

    .full-purpose {
        height: 120px;
    }

    input, textarea {
        padding: 10px 15px;
    }
}
</style>
