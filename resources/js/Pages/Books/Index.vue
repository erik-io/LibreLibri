<script lang="ts" setup>
import TextInput from '@/Components/TextInput.vue';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/components/ui/button';
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
import { AlertCircle, CheckCircle, Clock } from 'lucide-vue-next';
import { Search } from 'lucide-vue-next'
import { ref } from 'vue';

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
    showNotification('Das Buch wurde erfolgreich ausgeliehen.');
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
            <h3 class="text-lg leading-6 font-medium">Bücher</h3>
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
                    <div class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500">
                        <Search size="18"/>
                    </div>
                <TextInput
                    class="w-full text-sm pl-10 placeholder:text-gray-400"
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
                    <TableRow>
                        <TableCell> Der Herr der Ringe </TableCell>
                        <TableCell> J.R.R. Tolkien </TableCell>
                        <TableCell> 978-3-608-93981-1 </TableCell>
                        <TableCell class="h-[40px] whitespace-nowrap">
                            <!-- Verfügbar -->
                            <div class="flex items-center gap-1.5 h-full">
                            <CheckCircle class="h-4 w-4 text-green-500" />
                            Verfügbar
                            </div>
                        </TableCell>
                        <TableCell>
                            <Button
                                size="sm"
                                variant="default"
                                @click="
                                    handleLoan({
                                        title: 'Der Herr der Ringe',
                                        author: 'J.R.R. Tolkien',
                                        isbn: '978-3-608-93981-1',
                                    })
                                "
                            >
                                Ausleihen
                            </Button>
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell>
                            Harry Potter und der Stein der Weisen
                        </TableCell>
                        <TableCell> J.K. Rowling </TableCell>
                        <TableCell> 978-3-551-55677-8 </TableCell>
                        <TableCell class="h-[40px] whitespace-nowrap">
                            <!-- Reserviert -->
                            <div class="flex items-center gap-1.5 h-full">
                            <Clock class="h-4 w-4 text-yellow-500" />
                            Reserviert
                            </div>
                        </TableCell>
                        <TableCell>
                            <Button
                                disabled
                                size="sm"
                                variant="default"
                                @click="
                                    handleLoan({
                                        title: 'Harry Potter und der Stein der Weisen',
                                        author: 'J.K. Rowling',
                                        isbn: '978-3-551-55677-8',
                                    })
                                "
                            >
                                Ausleihen
                            </Button>
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell> Die unendliche Geschichte </TableCell>
                        <TableCell> Michael Ende </TableCell>
                        <TableCell> 978-3-7915-0460-3 </TableCell>
                        <TableCell class="h-[40px] whitespace-nowrap">
                            <!-- Ausgeliehen -->
                            <div class="flex items-center gap-1.5 h-full">
                            <AlertCircle class="h-4 w-4 text-red-500" />
                            Ausgeliehen
                            </div>
                        </TableCell>
                        <TableCell>
                            <Button
                                disabled
                                size="sm"
                                variant="default"
                                @click="
                                    handleLoan({
                                        title: 'Die unendliche Geschichte',
                                        author: 'Michael Ende',
                                        isbn: '978-3-7915-0460-3',
                                    })
                                "
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
