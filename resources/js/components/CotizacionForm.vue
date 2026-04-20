<template>
    <div class="formContainer">
        <h2>Solicite su cotización</h2>
        <p>
            Déjanos los detalles de tu requerimiento y te <br />
            enviaremos una propuesta adaptada a tus <br />
            necesidades en el menor tiempo posible.
        </p>
        <div v-if="title" class="productContainer">
            <div class="imgContainer">
                <img :src="`/storage/${imagenCover}`" :alt="title" />
            </div>
            <h3>{{ title }}</h3>
        </div>

        <Form @submit="onSubmit" :validation-schema="schema" class="space-y-6">
            <div class="form-group">
                <label class="form-label"
                    >Nombres y Apellidos: <span>*</span></label
                >
                <Field
                    v-model="form.name"
                    name="name"
                    type="text"
                    class="form-input"
                    placeholder="Tu nombre"
                />
                <ErrorMessage name="name" class="error-message" />
            </div>
            <div class="form-group">
                <label class="form-label"
                    >Nombre de la empresa (opcional)</label
                >
                <Field
                    v-model="form.company"
                    name="company"
                    type="text"
                    class="form-input"
                    placeholder="Nombre de tu empresa"
                />
            </div>

            <div class="form-group">
                <label class="form-label">DNI o RUC <span>*</span></label>
                <Field
                    v-model="form.document"
                    name="document"
                    type="text"
                    class="form-input"
                    placeholder="Ingresa tu DNI o RUC"
                />
                <ErrorMessage name="document" class="error-message" />
            </div>

            <div class="form-group">
                <label class="form-label"
                    >Correo electrónico <span>*</span></label
                >
                <Field
                    v-model="form.email"
                    name="email"
                    type="email"
                    class="form-input"
                    placeholder="correo@ejemplo.com"
                />
                <ErrorMessage name="email" class="error-message" />
            </div>

            <div class="form-group">
                <label class="form-label">Nro. de celular <span>*</span></label>
                <Field
                    v-model="form.phone"
                    name="phone"
                    type="tel"
                    class="form-input"
                    placeholder="987 654 321"
                />
                <ErrorMessage name="phone" class="error-message" />
            </div>

            <!-- <div class="checkbox-container">
                <Field
                    v-model="form.acceptTerms"
                    name="acceptTerms"
                    type="checkbox"
                    :value="true"
                />
                <label>
                    He leído y aceptado las
                    <a
                        href="/politicas-privacidad"
                        target="_blank"
                        class="text-amber-600 hover:underline"
                        >Políticas de Privacidad</a
                    >, los
                    <a
                        href="/terminos-uso"
                        target="_blank"
                        class="text-amber-600 hover:underline"
                        >Términos de uso</a
                    >
                    y el
                    <a
                        href="/tratamiento-datos"
                        target="_blank"
                        class="text-amber-600 hover:underline"
                        >Aviso de Privacidad</a
                    >.
                </label>
            </div> -->
            <div class="checkbox-container">
                <Field
                    v-model="form.acceptTerms"
                    name="acceptTerms"
                    type="checkbox"
                    :value="true"
                />
                <label>
                    He leído y acepto los t&eacute;rminos y condiciones
                </label>
            </div>
            <ErrorMessage name="acceptTerms" class="error-message" />

            <button type="submit" :disabled="isSubmitting" class="submit-btn">
                {{ isSubmitting ? "Enviando..." : "Enviar Solicitud" }}
            </button>
        </Form>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { Form, Field, ErrorMessage } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
const props = defineProps({
    title: {
        type: String,
        default: "",
    },
    imagenCover: {
        type: String,
        default: "",
    },
});

// Esquema de validación con Zod
const schema = toTypedSchema(
    z.object({
        name: z
            .string()
            .min(2, { message: "El nombre debe tener al menos 2 caracteres" })
            .max(100, { message: "El nombre es demasiado largo" }),

        company: z.string().optional(),

        document: z
            .string()
            .min(8, {
                message: "El DNI o RUC debe tener al menos 8 caracteres",
            })
            .max(20, { message: "El documento es demasiado largo" }),

        email: z
            .string()
            .email({ message: "Ingrese un correo electrónico válido" })
            .min(1, { message: "El correo es obligatorio" }),

        phone: z
            .string()
            .min(9, {
                message: "El número de celular debe tener al menos 9 dígitos",
            })
            .max(15, { message: "El número de celular es demasiado largo" }),

        // ← Esta es la corrección clave para que muestre tu mensaje personalizado
        acceptTerms: z
            .boolean({
                required_error: "Debes aceptar las políticas y términos",
                invalid_type_error: "Debes aceptar las políticas y términos",
            })
            .refine((val) => val === true, {
                message: "Debes aceptar las políticas y términos",
            }),
    }),
);

const emit = defineEmits(["success"]);

const form = ref({
    name: "",
    company: "",
    document: "",
    email: "",
    phone: "",
    acceptTerms: false,
});

const isSubmitting = ref(false);

const onSubmit = async (values) => {
    isSubmitting.value = true;

    try {
        console.log("Formulario enviado:", values);
        // Aquí va tu axios.post('/api/cotizacion', values)

        const dataToSend = {
            ...values,
            context_title: props.title || null, // ← Aquí lo incluimos
        };

        const response = await axios.post("/api/cotizacion", dataToSend);

        if (response.data.success) {
            emit("success");
            // Opcional: mostrar mensaje de éxito
            alert(
                "¡Cotización enviada correctamente! Nos contactaremos pronto.",
            );
        }

        // await new Promise((resolve) => setTimeout(resolve, 1000));

        form.value = {
            name: "",
            company: "",
            document: "",
            email: "",
            phone: "",
            context_title: "",
            acceptTerms: false,
        };
    } catch (error) {
        console.error(error);
    } finally {
        isSubmitting.value = false;
    }
};
</script>
