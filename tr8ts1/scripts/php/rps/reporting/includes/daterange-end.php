			<p><b>2) Ending With Date:</b></p>
			<select size="1" name="endmonth">
				<option <?php if (date("n") == 1) { echo "selected"; }?> value="1">January</option>
				<option <?php if (date("n") == 2) { echo "selected"; }?> value="2">February</option>
				<option <?php if (date("n") == 3) { echo "selected"; }?> value="3">March</option>
				<option <?php if (date("n") == 4) { echo "selected"; }?> value="4">April</option>
				<option <?php if (date("n") == 5) { echo "selected"; }?> value="5">May</option>
				<option <?php if (date("n") == 6) { echo "selected"; }?> value="6">June</option>
				<option <?php if (date("n") == 7) { echo "selected"; }?> value="7">July</option>
				<option <?php if (date("n") == 8) { echo "selected"; }?> value="8">August</option>
				<option <?php if (date("n") == 9) { echo "selected"; }?> value="9">September</option>
				<option <?php if (date("n") == 10) { echo "selected"; }?> value="10">October</option>
				<option <?php if (date("n") == 11) { echo "selected"; }?> value="11">November</option>
				<option <?php if (date("n") == 12) { echo "selected"; }?> value="12">December</option>
			</select>

			<select size="1" name="endday">
				<?php
					for($i = 1; $i <=31; $i++) {
						if (date("j") == $i) {
							?>
								<option <?php echo 'selected';?> value="<?php echo date("j");?>"><?php echo date("j");?></option>
							<?php
						}
						else {
							?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php
						}
					}
				?>
			</select>,

			<select size="1" name="endyear">
				<?php
				$thisYear = date("Y");
				/* output all the years from 1990 to this year */
					for($i = 1990; $i < $thisYear; $i++) {
						?>
							<option value="<?php echo $i; ?>"><?php echo $i;?></option>
						<?php
					}
				?>
				<!-- output this year -->
				<option selected value="<?php echo $thisYear;?>"><?php echo $thisYear;?></option>
			</select>			
