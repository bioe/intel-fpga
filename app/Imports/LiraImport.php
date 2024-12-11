<?php

namespace App\Imports;

use App\Models\Lira;
use App\Models\LiraBatch;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class LiraImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $errors = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $liraBatch = LiraBatch::create(['user_id' => auth()->id()]);
    
        foreach ($collection as $row) 
        {
            Lira::create([
                'external_revision' => $row['external_revision'] ?? null,
                'spec_code' => $row['spec_code'] ?? null,
                'spec_sequential_number' => $row['spec_sequential_number'] ?? null,
                'external_step' => $row['external_step'] ?? null,
                'processor_base_code' => $row['processor_base_code'] ?? null,
                'finished_good_type' => $row['finished_good_type'] ?? null,
                'internal_rev_step' => $row['internal_rev_step'] ?? null,
                'ic_category_type' => $row['ic_category_type'] ?? null,
                'item_market_name' => $row['item_market_name'] ?? null,
                'pincount' => $row['pincount'] ?? null,
                'market_code_name' => $row['market_code_name'] ?? null,
                'previous_reference_id' => $row['previous_reference_id'] ?? null,
                'product_grade' => $row['product_grade'] ?? null,
                'power_grade' => $row['power_grade'] ?? null,
                'transceiver_tile_config' => $row['transceiver_tile_config'] ?? null,
                'transceiver_count' => $row['transceiver_count'] ?? null,
                'transceiver_speed_ratio' => $row['transceiver_speed_ratio'] ?? null,
                'core_speed_ratio' => $row['core_speed_ratio'] ?? null,
                'product_variant' => $row['product_variant'] ?? null,
                'density' => $row['density'] ?? null,
                'density_uom' => $row['density_uom'] ?? null,
                'voltage_io' => $row['voltage_io'] ?? null,
                'programmed_ind' => $row['programmed_ind'] ?? null,
                'mm_technology' => $row['mm_technology'] ?? null,
                'pp_steering_committee' => $row['pp_steering_committee'] ?? null,
                'pb_free' => $row['pb_free'] ?? null,
                'custom_indicator' => $row['custom_indicator'] ?? null,
                'customer_custom_product' => $row['customer_custom_product'] ? (int)$row['customer_custom_product'] : null,                                                       
                'package_platform' => $row['package_platform'] ?? null,
                'package_text' => $row['package_text'] ?? null,
                'shipment_media' => $row['shipment_media'] ?? null,
                'trademark_family_name' => $row['trademarkfamily_name'] ?? null, 
                'fab_process' => $row['fab_process'] ?? null,
                'internal_stepping' => $row['internal_stepping'] ?? null,
                'speed_type' => $row['speed_type'] ?? null,
                'external_product_id' => $row['external_product_id'] ?? null,
                'speed' => (double)$row['speed'] ?? null,
                'die_code_name' => $row['die_code_name'] ?? null,
                'cust_part_no' => $row['cust_part_no'] ?? null,  
                'royalty_technology' => $row['royalty_technology'] ?? null,
                'comments' => $row['comments'] ?? null,
                'engineering_efforts' => $row['engineering_efforts'] ?? null,
                'sub_component_category_name' => $row['sub_component_category_name'] ?? null,
                'rldram_iii_mhz' => (int)$row['rldram_iii_mhz'] ?? null,
                'lvds_gbps' => $row['lvds_gbps'] ?? null,
                'mlab_simple_dual_port_mhz' => $row['mlab_simple_dual_port_mhz'] ?? null,
                'mlab_true_dual_port_mhz' => $row['mlab_true_dual_port_mhz'] ?? null,
                'lutram_mhz' => $row['lutram_mhz'] ?? null,
                'dsp_fixed_point_mode_mhz' => $row['dsp_fixed_point_mode_mhz'] ?? null,
                'dsp_floating_point_mode_mhz' => $row['dsp_floating_point_mode_mhz'] ?? null,
                'maib_mhz' => $row['maib_mhz'] ?? null,
                'esram_mhz' => $row['esram_mhz'] ?? null,
                'hps_mhz_rate' => $row['hps_mhz_rate'] ?? null,
                'ddr4_freq' => $row['ddr4_freq'] ?? null,
                'external_stepping' => $row['external_stepping'] ?? null,
                'l4_forecast_name' => $row['l4forecast_name'] ?? null,
                'mm' => $row['mm'] ?? null,
                'package_type' => $row['package_type'] ?? null,
                'qdf_sspec' => $row['qdfsspec'] ?? null,
                'sample_production_type' => $row['sampleproduction_type'] ?? null, 
                'lira_batch_id' => $liraBatch->id,
            ]);
        }
    }

    public function headingRow(): int
    {
        return 2;
    }   

     /**
     * Define validation rules.
     */
    public function rules(): array
    {
        return [
            'external_revision' => 'nullable|integer|min:0|max:255', 
            'spec_code' => 'nullable|string|max:10',
            'spec_sequential_number' => 'nullable|string|max:10',
            'external_step' => 'nullable|string|max:10',
            'processor_base_code' => 'nullable|string|max:255',
            'finished_good_type' => 'nullable|string|max:20',
            'internal_rev_step' => 'nullable|string|max:10',
            'ic_category_type' => 'nullable|string|max:30',
            'item_market_name' => 'nullable|string|max:20',
            'pincount' => 'nullable|integer|min:-32768|max:32767', 
            'market_code_name' => 'nullable|string|max:30',
            'previous_reference_id' => 'nullable|string|max:20',
            'product_grade' => 'nullable|string|max:10',
            'power_grade' => 'nullable|string|max:10',
            'transceiver_tile_config' => 'nullable|string|max:10',
            'transceiver_count' => 'nullable|integer|min:0|max:255', 
            'transceiver_speed_ratio' => 'nullable|integer|min:0|max:255',
            'core_speed_ratio' => 'nullable|integer|min:0|max:255',
            'product_variant' => 'nullable|string|max:10',
            'density' => 'nullable|integer|min:0|max:65535', 
            'density_uom' => 'nullable|string|max:10',
            'voltage_io' => 'nullable|numeric',
            'programmed_ind' => 'nullable|string|max:5',
            'mm_technology' => 'nullable|string|max:20',
            'pp_steering_committee' => 'nullable|string|max:10',
            'pb_free' => 'nullable|string|max:5',
            'custom_indicator' => 'nullable|string|max:5',
            'customer_custom_product' => 'nullable|boolean',
            'package_platform' => 'nullable|string|max:20',
            'package_text' => 'nullable|string|max:20',
            'shipment_media' => 'nullable|string|max:20',
            'trademark_family_name' => 'nullable|string|max:255',
            'fab_process' => 'nullable|string|max:10',
            'internal_stepping' => 'nullable|string|max:10',
            'speed_type' => 'nullable|string|max:30',
            'external_product_id' => 'nullable|string|max:20',
            'speed' => 'nullable|numeric',
            'die_code_name' => 'nullable|string|max:30',
            'cust_part_no' => 'nullable|string|max:20',
            'royalty_technology' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
            'engineering_efforts' => 'nullable|string',
            'sub_component_category_name' => 'nullable|string|max:10',
            'rldram_iii_mhz' => 'nullable|integer|min:0|max:65535', 
            'lvds_gbps' => 'nullable|numeric|min:0|max:999999.99', 
            'mlab_simple_dual_port_mhz' => 'nullable|integer|min:0|max:65535', 
            'mlab_true_dual_port_mhz' => 'nullable|integer|min:0|max:65535', 
            'lutram_mhz' => 'nullable|integer|min:0|max:65535', 
            'dsp_fixed_point_mode_mhz' => 'nullable|integer|min:0|max:65535', 
            'dsp_floating_point_mode_mhz' => 'nullable|integer|min:0|max:65535', 
            'maib_mhz' => 'nullable|integer|min:0|max:65535', 
            'esram_mhz' => 'nullable|integer|min:0|max:65535', 
            'hps_mhz_rate' => 'nullable|integer|min:0|max:65535', 
            'ddr4_freq' => 'nullable|integer|min:0|max:65535', 
            'external_stepping' => 'nullable|string|max:10',
            'l4_forecast_name' => 'nullable|string|max:255',
            'mm' => 'nullable|string|max:20',
            'package_type' => 'nullable|string|max:255',
            'qdf_sspec' => 'nullable|string|max:10',
            'sample_production_type' => 'nullable|string|max:20',
        ];
    }
}
