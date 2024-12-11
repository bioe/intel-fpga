<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lira', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedTinyInteger('external_revision')->nullable();
            $table->string('spec_code', 10)->nullable();
            $table->string('spec_sequential_number', 10)->nullable();
            $table->string('external_step', 10)->nullable();
            $table->string('processor_base_code')->nullable();
            $table->string('finished_good_type', 20)->nullable();
            $table->string('internal_rev_step', 10)->nullable();
            $table->string('ic_category_type', 30)->nullable();
            $table->string('item_market_name', 20)->nullable();
            $table->unsignedSmallInteger('pincount')->nullable();
            $table->string('market_code_name', 30)->nullable();
            $table->string('previous_reference_id', 20)->nullable();
            $table->string('product_grade', 10)->nullable();
            $table->string('power_grade', 10)->nullable();
            $table->string('transceiver_tile_config', 10)->nullable();
            $table->unsignedTinyInteger('transceiver_count')->nullable();
            $table->unsignedTinyInteger('transceiver_speed_ratio')->nullable();
            $table->unsignedTinyInteger('core_speed_ratio')->nullable();
            $table->string('product_variant', 10)->nullable();
            $table->unsignedSmallInteger('density')->nullable();
            $table->string('density_uom', 10)->nullable();
            $table->float('voltage_io')->nullable();
            $table->string('programmed_ind', 5)->nullable();
            $table->string('mm_technology', 20)->nullable();
            $table->string('pp_steering_committee', 10)->nullable();
            $table->string('pb_free', 5)->nullable();
            $table->string('custom_indicator', 5)->nullable();
            $table->boolean('customer_custom_product')->nullable();
            $table->string('package_platform', 20)->nullable();
            $table->string('package_text', 20)->nullable();
            $table->string('shipment_media', 20)->nullable();
            $table->string('trademark_family_name')->nullable();
            $table->string('fab_process', 10)->nullable();
            $table->string('internal_stepping', 10)->nullable();
            $table->string('speed_type', 30)->nullable();
            $table->string('external_product_id', 20)->nullable();
            $table->float('speed')->nullable();
            $table->string('die_code_name', 30)->nullable();
            $table->string('cust_part_no', 20)->nullable();
            $table->string('royalty_technology')->nullable();
            $table->text('comments')->nullable();
            $table->text('engineering_efforts')->nullable();	
            $table->string('sub_component_category_name', 10)->nullable();
            $table->unsignedSmallInteger('rldram_iii_mhz')->nullable();
            $table->decimal('lvds_gbps', 8, 2)->nullable();
            $table->unsignedSmallInteger('mlab_simple_dual_port_mhz')->nullable();
            $table->unsignedSmallInteger('mlab_true_dual_port_mhz')->nullable();
            $table->unsignedSmallInteger('lutram_mhz')->nullable();
            $table->unsignedSmallInteger('dsp_fixed_point_mode_mhz')->nullable();
            $table->unsignedSmallInteger('dsp_floating_point_mode_mhz')->nullable();
            $table->unsignedSmallInteger('maib_mhz')->nullable();
            $table->unsignedSmallInteger('esram_mhz')->nullable();
            $table->unsignedSmallInteger('hps_mhz_rate')->nullable();
            $table->unsignedSmallInteger('ddr4_freq')->nullable();
            $table->string('external_stepping', 10)->nullable();
            $table->string('l4_forecast_name')->nullable();
            $table->string('mm', 20)->nullable();
            $table->string('package_type')->nullable();
            $table->string('qdf_sspec', 10)->nullable();
            $table->string('sample_production_type', 20)->nullable();
            $table->unsignedBigInteger('lira_batch_id')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lira');
    }
};
