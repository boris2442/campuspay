<?php
namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PaiementsExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $total = 0;

    public function collection()
    {
        $paiements = Paiement::with('user')->get();

        // Calcul du total à la volée
        $this->total = $paiements->sum('montant_paye');

        return $paiements;
    }

    public function map($paiement): array
    {
        return [
            $paiement->user->name ?? 'N/A',
            ucfirst($paiement->tranche_paye),
            $paiement->montant_paye,
            ucfirst($paiement->mode_paiement),
            ucfirst($paiement->statut),
            $paiement->created_at->format('d/m/Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nom étudiant',
            'Tranche',
            'Montant payé',
            'Mode de paiement',
            'Statut',
            'Date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // On place le total juste après la dernière ligne de données
                $lastRow = $event->sheet->getHighestRow() + 1;

                $event->sheet->setCellValue("B{$lastRow}", 'Total :');
                $event->sheet->setCellValue("C{$lastRow}", $this->total);
                $event->sheet->getStyle("B{$lastRow}:C{$lastRow}")->getFont()->setBold(true);
            },
        ];
    }
}
