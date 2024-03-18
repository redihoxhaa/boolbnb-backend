@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="container py-4">
        <h1 class="pb-3">Analytics</h1>
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center mb-3">Filter by Apartment and Date Range</h2>
                <form id="filterForm">
                    @csrf <!-- Aggiungi questa direttiva per proteggere il form -->
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

    <!-- Assicurati di includere jQuery, Chart.js e Axios.js prima di utilizzarli -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
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

            // Funzione per generare le date tra due date
            // Funzione per generare tutte le date tra due date
            function getAllDates(startDate, endDate) {
                const dates = [];
                let currentDate = new Date(startDate);
                const end = new Date(endDate);

                while (currentDate <= end) {
                    dates.push(new Date(currentDate));
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                return dates;
            }

            // Funzione per aggiornare il grafico in base al filtro di data
            function updateChart(apartmentId, startDate, endDate) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                axios.get('http://localhost:8000/api/analytics', {
                        params: {
                            apartmentId: apartmentId,
                            startDate: startDate,
                            endDate: endDate
                        }
                    })
                    .then(function(response) {
                        console.log(response); // Visualizza l'intera risposta
                        const data = response.data;
                        const allDates = getAllDates(startDate,
                        endDate); // Genera tutte le date nel range selezionato
                        const visitsData = data.visits || [];
                        const messagesData = data.messages || [];

                        console.log('All Dates:', allDates); // Visualizza tutte le date nel range selezionato
                        console.log('Visits data:', visitsData); // Visualizza i dati delle visite
                        console.log('Messages data:', messagesData); // Visualizza i dati dei messaggi

                        // Aggiorna il grafico con i nuovi dati solo se sono definiti
                        if (visitsData.length > 0 || messagesData.length > 0) {
                            myChart.destroy(); // Distruggi il grafico esistente
                            myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: allDates.map(date => date
                                .toLocaleDateString()), // Converti le date in formato stringa locale
                                    datasets: [{
                                        label: 'Visits',
                                        data: allDates.map(date => {
                                            const visit = visitsData.find(item => item
                                                .date === date.toISOString().split(
                                                    'T')[0]);
                                            return visit ? visit.count :
                                            0; // Se c'è un dato, restituisci il conteggio, altrimenti 0
                                        }),
                                        fill: false,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        tension: 0.1
                                    }, {
                                        label: 'Messages',
                                        data: allDates.map(date => {
                                            const message = messagesData.find(item =>
                                                item.date === date.toISOString()
                                                .split('T')[0]);
                                            return message ? message.count :
                                            0; // Se c'è un dato, restituisci il conteggio, altrimenti 0
                                        }),
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
                        } else {
                            console.log('No data available for the chart.');
                            // Aggiungi qui il codice per stampare il messaggio desiderato
                            // Ad esempio:
                            $('#myChart').replaceWith(
                                '<div class="alert alert-info">No data available for the chart.</div>');
                        }
                    })
                    .catch(function(error) {
                        console.error('Error retrieving statistics data', error);
                    });
            }



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
