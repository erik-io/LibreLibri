<script setup lang="ts">
import { AlertCircle, CheckCircle, Clock } from 'lucide-vue-next';

// Mit defineProps deklarieren wir, welche Eigenschaften unsere Komponente von außen empfangen kann
// Der TypeScript-Compiler weiß dadurch auch, welche Datentypen erwartet werden
const props = defineProps({
    status: {
        type: Object,
        required: true
    }
});

// Wir definieren unsere Status-Konfiguration als normale Konstante
// In der Composition API können wir das direkt im Setup-Bereich machen
const statusConfig = {
    available: {
        icon: CheckCircle,
        iconClass: 'text-green-500',
        textClass: 'text-green-700'
    },
    reserved: {
        icon: Clock,
        iconClass: 'text-yellow-500',
        textClass: 'text-yellow-700'
    },
    loaned: {
        icon: AlertCircle,
        iconClass: 'text-red-500',
        textClass: 'text-red-700'
    },
    unavailable: {
        icon: AlertCircle,
        iconClass: 'text-gray-500',
        textClass: 'text-gray-700'
    }
};

// In der Composition API können wir einfach die aktuelle Konfiguration berechnen
// Der Zugriff auf props erfolgt direkt über das props-Objekt
const config = statusConfig[props.status.type] || statusConfig.unavailable;
</script>

<template>
    <div class="flex h-[40px] items-center gap-1.5 whitespace-nowrap">
        <!-- Wir können nun direkt config verwenden -->
        <component
            :is="config.icon"
            class="h-4 w-4"
            :class="config.iconClass"
        />
        <span :class="config.textClass">
            {{ status.label }}
        </span>
    </div>
</template>
