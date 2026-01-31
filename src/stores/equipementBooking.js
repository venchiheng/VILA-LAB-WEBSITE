import { defineStore } from "pinia";
// import { api } from "../lib/api";
import api from "../services/api";
import axios from "axios";

export const useEquipmentBookingStore = defineStore("equipmentBooking", {
  state: () => ({
    bookings: [],
    booking: null,
    loading: false,
    error: null,
  }),

  actions: {
    /* ======================
       FETCH ALL BOOKINGS
       ====================== */
    async fetchBookings() {
      this.loading = true;
      this.error = null;

      try {
        const res = await api.get("http://44.223.137.10:8000/api/equipment-bookings");
        this.bookings = res.data.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load bookings";
      } finally {
        this.loading = false;
      }
    },

    /* ======================
       FETCH SINGLE BOOKING
       ====================== */
    async fetchBooking(id) {
      this.loading = true;
      this.error = null;

      try {
        const res = await api.get(`/equipment-bookings/${id}`);
        this.booking = res.data.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load booking";
      } finally {
        this.loading = false;
      }
    },

    /* ======================
       CREATE BOOKING
       ====================== */
    async createBooking(payload) {
      this.loading = true;
      this.error = null;

      try {
        const res = await api.post("http://44.223.137.10:8000/api/equipment-bookings/equipment-bookings", payload);
        this.bookings.unshift(res.data.data);
        return res.data.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Booking failed";
        throw err;
      } finally {
        this.loading = false;
      }
    },

    /* ======================
       APPROVE BOOKING
       ====================== */
      async approveBooking(id) {
        this.loading = true;

        try {
          const res = await api.put(`http://44.223.137.10:8000/api/equipment-bookings/${id}/approve`);
          this.updateBooking(res.data.data);
        } catch (err) {
          this.error = err.response?.data?.message || "Approve failed";
        } finally {
          this.loading = false;
        }
      },

    /* ======================
       REJECT BOOKING
       ====================== */
    async rejectBooking(id) {
      this.loading = true;

      try {
        const res = await api.put(`http://44.223.137.10:8000/api/equipment-bookings/${id}/reject`);
        this.updateBooking(res.data.data);
      } catch (err) {
        this.error = err.response?.data?.message || "Reject failed";
      } finally {
        this.loading = false;
      }
    },

    /* ======================
       RETURN EQUIPMENT
       ====================== */
    async returnBooking(id) {
      this.loading = true;

      try {
        const res = await api.put(`http://44.223.137.10:8000/api/equipment-bookings/${id}/return`);
        this.updateBooking(res.data.data);
      } catch (err) {
        this.error = err.response?.data?.message || "Return failed";
      } finally {
        this.loading = false;
      }
    },

    /* ======================
    In Use EQUIPMENT
    ====================== */
    async inuseBooking(id) {
      this.loading = true;

      try {
        const res = await api.put(`http://44.223.137.10:8000/api/equipment-bookings/${id}/in_use`);
        this.updateBooking(res.data.data);
      } catch (err) {
        this.error = err.response?.data?.message || "In use failed";
      } finally {
        this.loading = false;
      }
    },
   
    /* ======================
    Overdue EQUIPMENT
    ====================== */
    async overdueBooking(id) {
      this.loading = true;

      try {
        const res = await api.put(`http://44.223.137.10:8000/api/equipment-bookings/${id}/overdue`);
        this.updateBooking(res.data.data);
      } catch (err) {
        this.error = err.response?.data?.message || "Overdue failed";
      } finally {
        this.loading = false;
      }
    },


    /* ======================
       HELPER
       ====================== */
    updateBooking(updated) {
      const index = this.bookings.findIndex(b => b.id === updated.id);
      if (index !== -1) {
        this.bookings[index] = updated;
      }
      if (this.booking?.id === updated.id) {
        this.booking = updated;
      }
    },
  },
});
