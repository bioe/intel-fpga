<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;

class Speed extends BaseModel
{
    protected $table = 'speed';

    protected $fillable = [
        'external_revision',
        'spec_code',
        'spec_sequential_number',
        'external_step',
        'processor_base_code',
        'finished_good_type',
        'internal_rev_step',
        'ic_category_type',
        'item_market_name',
        'pincount',
        'market_code_name',
        'previous_reference_id',
        'product_grade',
        'power_grade',
        'transceiver_tile_config',
        'transceiver_count',
        'transceiver_speed_ratio',
        'core_speed_ratio',
        'product_variant',
        'density',
        'density_uom',
        'voltage_io',
        'programmed_ind',
        'mm_technology',
        'pp_steering_committee',
        'pb_free',
        'custom_indicator',
        'customer_custom_product',
        'package_platform',
        'package_text',
        'shipment_media',
        'trademark_family_name',
        'fab_process',
        'internal_stepping',
        'speed_type',
        'external_product_id',
        'speed',
        'die_code_name',
        'cust_part_no',
        'royalty_technology',
        'comments',
        'engineering_efforts',
        'sub_component_category_name',
        'rldram_iii_mhz',
        'lvds_gbps',
        'mlab_simple_dual_port_mhz',
        'mlab_true_dual_port_mhz',
        'lutram_mhz',
        'dsp_fixed_point_mode_mhz',
        'dsp_floating_point_mode_mhz',
        'maib_mhz',
        'esram_mhz',
        'hps_mhz_rate',
        'ddr4_freq',
        'l4_forecast_name',
        'mm',
        'package_type',
        'qdf_sspec',
        'sample_production_type',
        'speed_batch_id',
    ];

    public function getTableColumns()
    {
        $excludedColumns = ['id', 'created_at', 'updated_at', 'deleted_at', 'speed_batch_id'];
        $columns = Schema::getColumnListing($this->getTable());
        return array_values(array_diff($columns, $excludedColumns));
    }

    /*
    * Build Table Header
    */
    public static function header()
    {
        $headers = [];
        return array_merge($headers, [
            ['field' => 'name', 'title' => 'Name', 'sortable' => true],
            ['field' => 'created_at', 'title' => 'Created At'],
        ]);
    }

    public function speedBatch()
    {
        return $this->belongsTo(SpeedBatch::class);
    }
}
