<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
                <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Status</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Der Herr der Ringe
                        </td>
                        <td>
                            J.R.R. Tolkien
                        </td>
                        <td>
                            978-3-608-93981-1
                        </td>
                        <td>
                            Verfügbar
                        </td>
                        <td>
                            <PrimaryButton>
                                Ausleihen
                            </PrimaryButton>
                        </td>
                    </tr>
                    <tr>
                      <td>
                        Harry Potter und der Stein der Weisen
                      </td>
                      <td>
                        J.K. Rowling
                      </td>
                      <td>
                        978-3-551-55677-8
                      </td>
                      <td>
                        Reserviert
                      </td>
                      <td>
                        <SecondaryButton>
                          Ausleihen
                        </SecondaryButton>
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
                      <td>
                        Ausgeliehen
                      </td>
                      <td>
                        <SecondaryButton>
                          Ausleihen
                        </SecondaryButton>
                      </td>
                    </tr>
                </tbody>
            </table>
        </AuthenticatedLayout>
</template>

<style scoped></style>
