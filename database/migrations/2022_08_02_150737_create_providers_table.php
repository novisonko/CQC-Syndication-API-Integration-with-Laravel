<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('providerId');
            $table->string('locationIds');
            $table->string('organisationType');
            $table->string('ownershipType');
            $table->string('type');
            $table->string('name');
            $table->string('brandId');
            $table->string('brandName');
            $table->string('registrationStatus');
            $table->date('registrationDate');
            $table->string('companiesHouseNumber');
            $table->integer('charityNumber');
            $table->string('website');
            $table->string('postalAddressLine1');
            $table->string('postalAddressLine2');
            $table->string('postalAddressTownCity');
            $table->string('postalAddressCounty');
            $table->string('region');
            $table->string('postalCode');
            $table->integer('uprn');
            $table->double('onspdLatitude');
            $table->double('onspdLongitude');
            $table->string('mainPhoneNumber');
            $table->string('inspectionDirectorate');
            $table->string('constituency');
            $table->string('localAuthority');
            $table->date('lastInspection');
            $table->integer('timestampUpdated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
};
