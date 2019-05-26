<template>
    <v-app>
        <section class="login">
            <v-form v-model="valid" ref="form" lazy-validation @submit="submit()">
                <v-container>
                    <v-layout align-center justify-center row>
                        <v-flex
                                xs12
                                md4
                        >
                            <v-text-field
                                    label="E-mail"
                                    v-model="email"
                                    :error-messages="errorsEmail"
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                    required
                            />
                            <v-text-field
                                    label="Password"
                                    type="password"
                                    v-model="password"
                                    :error-messages="errorsPassword"
                                    @input="$v.password.$touch()"
                                    @blur="$v.password.$touch()"
                                    required
                            />
                            <v-btn
                                    color="info"
                                    class="loginButton"
                                    :loading="processing"
                                    @click.prevent="submit"
                            >
                                login
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-form>
        </section>
    </v-app>
</template>

<script>
  import {validationMixin} from 'vuelidate';
  import {required, email} from 'vuelidate/lib/validators';
  import {login} from '../../services/api';

  export default {
    mixins: [validationMixin],
    validations: {
      email: { required, email },
      password: { required }
    },
    data: () => ({
      valid: true,
      email: '',
      password: '',
      processing: false,
      serverError: false,
    }),

    computed: {
      errorsEmail() {
        const errors = [];
        if (!this.$v.email.$dirty) return errors;
        !this.$v.email.email && errors.push('Must be valid e-mail');
        !this.$v.email.required && errors.push('E-mail is required');
        this.serverError && errors.push('Credentials are invalid');
        return errors;
      },
      errorsPassword() {
        const errors = [];
        if (!this.$v.email.$dirty) return errors;
        !this.$v.password.required && errors.push('Password is required');
        this.serverError && errors.push('Credentials are invalid');
        return errors;
      },
    },

    methods: {
      async submit() {
        if (this.$v.$invalid) {
          this.$v.$touch();
          return;
        }
        this.processing = true;
        try {
          const result = await login(this.email, this.password);
          this.processing = false;
          this.$router.push('/');
        } catch (err) {
          this.serverError = err.response.data.message;
          this.processing = false;
        }
      },
    },
  };
</script>

<style>
    form {
        margin-top: 100px;
    }
</style>