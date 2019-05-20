<template>
    <div>
        <input type="email" name="email" v-model="email">
        <input type="password" name="password" v-model="password">
        <button type="button"
                class="loginButton"
                :loading="processing"
                @click.prevent="submit"
                :disabled="!valid"
        >
            Submit
        </button>
    </div>
</template>

<script>
 import { validationMixin } from 'vuelidate';
 import { required, email } from 'vuelidate/lib/validators';
  import { login, setAuthToken } from '../../services/api';

  export default {
   mixins: [validationMixin],
    validations: {
      email: { required, email }
    },
    data: () => ({
      valid: true,
      email: '',
      password: '',
      processing: false,
      serverError: false,
    }),

    computed: {
      emailErrors() {
        const errors = [];
        if (!this.$v.email.$dirty) return errors;
        !this.$v.email.email && errors.push('Must be valid e-mail');
        !this.$v.email.required && errors.push('E-mail is required');
        this.serverError && errors.push('E-mail is invalid');
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
          const { token } = result;
          window.localStorage.setItem('token', token);
          setAuthToken(token);
          this.$router.push('/');
        } catch (err) {
          this.serverError = true;
          this.processing = false;
        }
      },
    },
  };
</script>

<style>
    .login {
        width: 260px;
        margin: auto;
        padding: 16px;
    }
    .loginButton{
        display: block;
        margin: auto;
    }
    .error {
        font-size: 12px;
        color: red;
    }
</style>
