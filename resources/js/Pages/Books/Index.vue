<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { Button } from '@/components/ui/button';
import { CheckCircle, AlertCircle, Clock } from 'lucide-vue-next';

const handleLoan = () => {
  // Hier kommt später die Logik zum Ausleihen des Buches hin
    alert('Buch ausgeliehen');
};

</script>

<template>
        <!-- Titel der Seite -->
        <Head title="Bücher" />
        <!-- Layout -->
        <AuthenticatedLayout>
            <!-- Header -->
            <template #header>
                <h1>
                    Bücher
                </h1>
                <p>
                    Hier findest du alle Bücher, die in der Bibliothek verfügbar sind.
                </p>
            </template>

            <!-- Suchfeld -->
          <TextInput class="w-full"
              placeholder="Suche nach Titel, Autor, oder ISBN..."
              type="text"
           model-value=""/>


            <!-- Büchertabelle -->
            <table class="w-full text-left">
                <thead class="border-b">
                    <tr>
                        <th>Titel</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Status</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                <tr class="border-b">
                        <td>
                            Der Herr der Ringe
                        </td>
                        <td>
                            J.R.R. Tolkien
                        </td>
                        <td>
                            978-3-608-93981-1
                        </td>
                      <td class="flex items-center gap-2">
                        <!-- Verfügbar -->
                        <CheckCircle class="w-5 h-5 text-green-500"/>
                        Verfügbar
                        </td>
                        <td>
                            <Button
                              variant="default"
                            size="sm"
                              @click="handleLoan"
                            >
                                Ausleihen
                            </Button>
                        </td>
                    </tr>
                    <tr class="border-b">
                      <td>
                        Harry Potter und der Stein der Weisen
                      </td>
                      <td>
                        J.K. Rowling
                      </td>
                      <td>
                        978-3-551-55677-8
                      </td>
                      <td class="flex items-center gap-2">
                        <!-- Reserviert -->
                        <Clock class="w-5 h-5 text-yellow-500"/>
                        Reserviert
                      </td>
                      <td>
                        <Button
                        variant="default"
                        size="sm"
                        @click="handleLoan"
                        disabled>
                          Ausleihen
                        </Button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Die unendliche Geschichte
                      </td>
                      <td>
                        Michael Ende
                      </td>
                      <td>
                        978-3-7915-0460-3
                      </td>
                      <td class="flex items-center gap-2">
                        <!-- Ausgeliehen -->
                        <AlertCircle class="w-5 h-5 text-red-500"/>
                        Ausgeliehen
                      </td>
                      <td>
                        <Button
                        variant="default"
                        size="sm"
                        @click="handleLoan"
                        disabled>
                          Ausleihen
                        </Button>
                      </td>
                    </tr>
                </tbody>
            </table>
        </AuthenticatedLayout>
</template>

<style scoped></style>
