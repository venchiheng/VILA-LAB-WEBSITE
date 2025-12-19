<template>
    <v-form>
        <!-- Row 1 -->
        <v-row dense>
            <v-col cols="12" md="6">
                <v-text-field :value="fullName" @input="$emit('update:fullName', $event.target.value)"
                    placeholder="Enter your full name" variant="outlined" rounded="xl" hide-details />

            </v-col>

            <v-col cols="12" md="6">
                <v-text-field :value="memberId" @input="$emit('update:memberId', $event.target.value)"
                    placeholder="Enter your member ID" variant="outlined" rounded="xl" hide-details />
            </v-col>
        </v-row>

        <!-- Row 2 -->
        <v-row dense>
            <v-col cols="12">
                <v-textarea :value="purpose" @input="$emit('update:purpose', $event.target.value)"
                    placeholder="Enter your purpose" variant="outlined" rounded="xl" hide-details />
            </v-col>
        </v-row>
    </v-form>
</template>

<script setup>
const props = defineProps({
    fullName: String,
    memberId: String,
    purpose: String
})

const emit = defineEmits(['update:fullName', 'update:memberId', 'update:purpose'])
</script>
