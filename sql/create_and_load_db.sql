-- Create the table and a suitable index.
DROP TABLE IF EXISTS electricity_meter_reading;
CREATE TABLE electricity_meter_reading (
  id INTEGER PRIMARY KEY,
  supplier TEXT,
  reading_type TEXT,
  reading_date TEXT,
  meter_value INTEGER
);
CREATE INDEX emr_date_index ON electricity_meter_reading(reading_date);

-- Load the CSV source file into a temporary table.
DROP TABLE IF EXISTS tmp;
.mode csv
.import data/electricity_meter_readings.csv tmp


-- Copy into the destination table.
INSERT INTO electricity_meter_reading
  (supplier, reading_type, reading_date, meter_value)
SELECT * FROM tmp;

-- Remove the temporary table.
DROP TABLE tmp;

