<script lang="ts" setup>
import TextInput from '@/Components/TextInput.vue';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/components/ui/button';
import BookStatus from '@/Components/BookStatus.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/Components/ui/dialog';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps({
    books: {
        type: Object,
        required: true,
    },
});

// Status für den Dialog
const isDialogOpen = ref(false);
const selectedBook = ref(null);

// Handler für das Ausleihen eines Buches
const handleLoan = (book) => {
    selectedBook.value = book;
    isDialogOpen.value = true;
};

// Status für Benachrichtigungen
const showAlert = ref(false);
const alertMessage = ref('');

// Bestätigung der Ausleihe
const confirmLoan = () => {
    // Hier später die Ausleihlogik implementieren
    console.log('Buch wird ausgeliehen:', selectedBook.value);
    isDialogOpen.value = false;

    // Alert anzeigen
    showNotification(selectedBook.value.title + ' von ' + selectedBook.value.author + ' wurde ausgeliehen.');
};

// Alert anzeigen für 3 Sekunden
const showNotification = (message: string) => {
    alertMessage.value = message;
    showAlert.value = true;
    setTimeout(() => {
        showAlert.value = false;
    }, 3000);
};
</script>

<template>
    <!-- Titel der Seite -->
    <Head title="Bücher" />
    <!-- Layout -->
    <AuthenticatedLayout>
        <!-- Header -->
        <template #header>
            <h3 class="text-lg font-medium leading-6">Bücher</h3>
            <p class="mt-1 text-sm">
                Hier findest du alle Bücher, die in der Bibliothek verfügbar
                sind.
            </p>
        </template>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Suchleiste -->
            <div class="mb-6 mt-2">
                <div class="relative">
                    <!-- Suchsymbol -->
                    <div
                        class="pointer-events-none absolute bottom-0 left-0 top-0 flex items-center pl-2 text-gray-500"
                    >
                        <Search size="18" />
                    </div>
                    <TextInput
                        class="w-full pl-10 text-sm placeholder:text-gray-400"
                        model-value=""
                        placeholder="Suche nach Titel, Autor, oder ISBN..."
                        type="text"
                    />
                </div>
            </div>

            <!-- Büchertabelle -->
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Titel</TableHead>
                        <TableHead>Autor</TableHead>
                        <TableHead>ISBN</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Aktionen</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="book in books.data" :key="book.id">
                        <TableCell> {{ book.title }} </TableCell>
                        <TableCell> {{ book.authors.full_name }} </TableCell>
                        <TableCell> {{ book.isbn.isbn13 }} </TableCell>
                        <TableCell>
                            <BookStatus :status="book.status" />
                        </TableCell>
                        <TableCell>
                            <Button
                                size="sm"
                                variant="default"
                                @click="
                                    handleLoan({
                                        title: book.title,
                                        author: book.authors.formatted,
                                        isbn: book.isbn.isbn13,
                                    })
                                "
                                :disabled="book.status.type !== 'available'"
                            >
                                Ausleihen
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Ausleih-Dialog -->
        <Dialog v-model:open="isDialogOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle> Ausleihe bestätigen </DialogTitle>
                    <DialogDescription>
                        Möchtest du das folgende Buch ausleihen?
                        <div v-if="selectedBook" class="mt-2">
                            <p>
                                <strong>Titel:</strong> {{ selectedBook.title }}
                            </p>
                            <p>
                                <strong>Autor:</strong>
                                {{ selectedBook.author }}
                            </p>
                            <p>
                                <strong>ISBN:</strong> {{ selectedBook.isbn }}
                            </p>
                        </div>
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" @click="isDialogOpen = false">
                        Abbrechen
                    </Button>
                    <Button @click="confirmLoan"> Ausleihen </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <!-- Benachrichtigungen -->
        <Alert
            v-if="showAlert"
            class="fixed bottom-4 right-4 mt-4 w-auto"
            variant="default"
        >
            <AlertDescription>
                {{ alertMessage }}
            </AlertDescription>
        </Alert>
    </AuthenticatedLayout>
</template>

<style scoped></style>
