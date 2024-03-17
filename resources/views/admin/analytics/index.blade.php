@extends('layouts.admin')

@section('title')
    Analytics
@endsection

@section('content')
    <div class="container py-4">
        <h1 class="pb-3">Analytics</h1>
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center mb-3">Filter by Apartment and Date Range</h2>
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="apartmentSelect" class="form-label">Select Apartment</label>
                        <select class="form-select" id="apartmentSelect" name="apartmentId">
                            <option value="">Select Apartment</option>
                            @foreach ($apartments as $apartment)
                                <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate">
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>
            </div>
            <div class="col-md-8">
                <h2 class="text-center mb-3">Analytics Chart</h2>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Inizializza il grafico con dati vuoti
            const ctx = document.getElementById('myChart').getContext('2d');
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {},
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Funzione per aggiornare il grafico in base al filtro di data
            function updateChart(apartmentId, startDate, endDate) {
                // Esegui una chiamata AJAX al backend per ottenere i dati filtrati
                // Sostituisci questa parte con la tua logica di backend per ottenere i dati filtrati
                // Dati di esempio
                const labels = ['2024-03-01', '2024-03-02', '2024-03-03']; // Esempio di etichette per gli assi x
                const visitsData = [10, 20, 15]; // Esempio di dati per le visite
                const messagesData = [5, 8, 6]; // Esempio di dati per i messaggi

                // Aggiorna il grafico con i nuovi dati
                myChart.destroy(); // Distruggi il grafico esistente
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Visits',
                            data: visitsData,
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.1
                        }, {
                            label: 'Messages',
                            data: messagesData,
                            fill: false,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Gestisci la sottomissione del modulo di filtro
            $('#filterForm').submit(function(e) {
                e.preventDefault();
                const apartmentId = $('#apartmentSelect').val();
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                updateChart(apartmentId, startDate, endDate);
            });
        });
    </script>
@endsection
