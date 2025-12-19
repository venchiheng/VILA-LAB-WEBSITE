<template>
    <div class="wrapper">
        <div class="images">
            <img :src="equipment.thumbnail" alt="Equipment Thumbnail">
            <div class="more">
                <img v-for="value in source" :key="value" :src="value" alt="more image" />
            </div>
        </div>
        <div class="details">
            <h1>{{ equipment.name }}</h1>
            <div class="chips-list">
                <v-chip-group>
                    <v-chip :style="{ backgroundColor: statusColor, color: '#fff' }" variant="flat">{{ equipment.status}}</v-chip>
                    <v-chip class="condition" variant="flat">{{ equipment.condition}}</v-chip>
                </v-chip-group>
            </div>
            <div class="description">
                <h4>Description</h4>
                <div class="html-content" v-html="equipment.htmlContent"></div>
            </div>
            <quantitySelector></quantitySelector>
            <button @click="showSelectDate = true" class="sb-btn">
                <Icon icon="ic:round-add" />
                Start Booking
            </button>
            <div class="policy">
                <h4>Policy</h4>
                <ul>
                    <li>Equipment may only be borrowed with prior approval from lab staff or the lab manager.</li>
                    <li>Borrowers must record their name, item, date, and expected return time in the equipment booking
                        system.</li>
                    <li>Equipment must be handled responsibly and used only for academic or project-related purposes.
                    </li>
                    <li>Borrowers are fully responsible for any damage, loss, or malfunction occurring during the
                        borrowing period.</li>
                    <li>All items must be returned on time and in the same condition. Late returns may affect future
                        borrowing privileges.</li>
                    <li>Some high-value or sensitive equipment may require additional authorization.</li>
                </ul>
            </div>
        </div>
    </div>
    <SelectDate v-model="showSelectDate" :equipment="equipment" @confirm="handleBooking"/>
</template>

<script setup>
import { Icon } from '@iconify/vue';
import quantitySelector from './quantity-selector.vue';
import { computed } from 'vue';
import { ref } from 'vue';
import SelectDate from './selectDate.vue';
const showSelectDate = ref(false)


const props = defineProps({
    equipment: Object,
    source: Array,
    color: String,
    htmlContent: String
})
const statusColor = computed(() => {
    switch (props.equipment.status.toLowerCase()) {
        case 'available':
            return 'var(--color-success)';
        case 'booked':
            return 'var(--color-warning)';
    }
})

const handleBooking = (data) => {
  console.log('BOOKING DATA:', data)
}

</script>

<style scoped>
.wrapper {
    padding-inline: 156px;
    padding-top: 56px;
    padding-bottom: 56px;
    display: flex;
    flex-direction: row;
    gap: 68px;
}
.details{
    display: flex;
    flex-direction: column;
    gap: 12px;
    justify-content: left;
    align-items: start;
}
.images {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 40%;
}
.more {
    display: flex;
    flex-direction: row;
    gap: 12px;
}
.more img {
    width: 70px;
    height: 70px;
    object-fit: cover;
}
.chips-list {
    margin-bottom: 12px;
    display: flex;
    flex-direction: row;
    gap: 12px;
}
.condition {
    border: 1px solid var(--color-primary);
    color: var(--color-primary);
    background-color: transparent;
}
.description {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 24px;
    align-items: start;
}
.html-content {
    text-align: left;
}
.sb-btn {
    width: 100%;
    background-color: var(--color-primary);
    color: white;
    border: none;
    border-radius: 40px;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
}
.sb-btn:hover {
    background-color: var(--color-secondary);
    transition: background-color 0.3s;
    color: var(--color-primary);
}
.policy {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: start;
}
.policy ul {
  list-style-type: disc;
  padding-left: 20px;
  text-align: left;
}

.policy li {
  margin-bottom: 8px;
}
</style>