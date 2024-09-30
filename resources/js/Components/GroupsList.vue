<script setup>
import GroupItem from "./GroupItem.vue";
import dayjs from "dayjs";
import { ref, defineProps } from "vue";
import { hasRole } from "@/util";
import axios from "axios";
const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});
const locks = ref(props.project.locks);
const fetchLocks = () => {
    axios.post('/api/locks/get-entity-locks', {
        lockable_id: props.project.id,
        lockable_type: 'Project' 
    })
    .then((response) => {
        locks.value = response.data;
    })
    .catch((error) => {
        console.error('Error fetching locks:', error);
    });
};
const handleLockChange = (lock, index) => {
    const confirm = window.confirm("Are you sure you want to change the status?");
    if (confirm) {
    const options = {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        url: route("locks.update", lock.id),
        data: {
            is_locked: lock.is_locked,
        },
    };
    axios
        .request(options)
        .then((response) => {
            console.log(response.data);
        })
        .catch((error) => {
            console.error(error);
        });
    } else {
        locks.value[index].is_locked = !locks.value[index].is_locked;
    }
};
fetchLocks();
// Compute totals for units, price, and overall total
const computeTotals = (groups, months) => {
    let totalUnits = 0;
    let totalPrice = 0;
    let totalValue = 0;
    let monthlyTotals = {};
    // Array(months.length).fill(0); 
    months.forEach(month => {
        monthlyTotals[dayjs(month).format("MM YY")] = 0; 
    });
    groups.forEach(group => {
        group.tasks.forEach(task => {
            // totalUnits += task.quantity;
            totalPrice += task.price;
            totalValue += task.quantity * task.price;

            task.activities.forEach(activity => {
                const activityDate = dayjs(activity.date);
                const monthKey = activityDate.format("MMMM YYYY"); 
                if (monthlyTotals.hasOwnProperty(monthKey)) {
                    monthlyTotals[monthKey] += activity.value; 
                }
            });
        });
    });

    return { totalUnits, totalPrice, totalValue, monthlyTotals };
};

const totals = computeTotals(props.project.groups, props.project.months);


</script>
<template>
    <div class="overflow-x-auto">
        <table class="table table-pin-rows table-pin-cols">
            <thead class="text-center">
                <tr>
                    <th>Tasks</th>
                    <th>UNIT</th>
                    <th>No. of Units</th>
                    <th>Unit Price</th>
                    <th>Total Task Value</th>
                    <th
                        class="p-0"
                        v-for="month in project.months"
                        :key="month"
                    >
                        {{ dayjs(month).format("MMM-YY") }}
                    </th>
                    <th>Units Done</th>
                    <th>Units incl Forecast</th>
                    <th>Amount Done</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td
                        width="56px"
                        class="px-0.5 text-xs"
                        v-for="(lock, index) in locks"
                        :key="lock.date"
                        :class="{
                            'tracking-[2px]': locks[index].is_locked,
                        }">
                        <span>{{ locks[index].is_locked ? "Actual" : "Forecast" }}</span>
                        <br>
                        <input
                            v-if="hasRole(['Admin', 'Super Admin', 'Manager'], auth.user)"
                            class="checkbox checkbox-primary w-4 h-4"
                            type="checkbox"
                            v-model="locks[index].is_locked"
                            @change="handleLockChange(lock, index)"
                            :disabled="locks[index].is_locked || lock.disabled"
                            style="width: 16px; height: 16px;"/>
                    </td>
                </tr>
                <GroupItem
                :auth="auth"
                    v-for="group in project.groups"
                    :key="group.id"
                    :group="group"
                    :locks="locks"
                    :min="project.activity_start_date"
                    :max="
                        dayjs(project.activity_start_date)
                            .add(project.clinical_duration, 'month')
                            .subtract(1, 'day')
                            .format('YYYY-MM-DD')"/>
                    <tr>
                    <th colspan="2">Total</th>
                    <th></th>
                    <th>{{ totals.totalPrice }}</th>
                    <th>{{ totals.totalValue }}</th>
                    <th></th>
                    <!-- <th v-for="(monthTotal, index) in totals.monthlyTotals" :key="index">
                        {{ monthTotal.toFixed(0) }} 
                    </th> -->
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>

            </tbody>
        </table>
    </div>
</template>




