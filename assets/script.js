function toggleSidebar(){
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

function initKategoriChart(labels, data){
    const ctx = document.getElementById('chartKategori').getContext('2d');

    new Chart(ctx,{
        type:'bar',
        data:{
            labels: labels,
            datasets:[{
                label:'Jumlah Dokumen',
                data: data,
                backgroundColor:[
                    '#2563eb',
                    '#16a34a',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#06b6d4'
                ]
            }]
        },
        options:{
            responsive:true,
            scales:{
                y:{
                    beginAtZero:true,
                    precision:0
                }
            }
        }
    });
    document.addEventListener("DOMContentLoaded", function(){

    const toggleBtn = document.querySelector(".toggle-btn");
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");

    if(toggleBtn){
        toggleBtn.addEventListener("click", function(){
            sidebar.classList.toggle("active");
            content.classList.toggle("full");
        });
    }

});
}