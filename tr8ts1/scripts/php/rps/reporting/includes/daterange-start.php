			<p><b>1) Starting With Date:</b></p>
			<select size="1" name="startmonth">
			          <option selected value="1">January</option>
			          <option value="2">February</option>
			          <option value="3">March</option>
			          <option value="4">April</option>
			          <option value="5">May</option>
			          <option value="6">June</option>
			          <option value="7">July</option>
			          <option value="8">August</option>
			          <option value="9">September</option>
			          <option value="10">October</option>
			          <option value="11">November</option>
			          <option value="12">December</option>
		        </select>

			<select size="1" name="startday">
				<option selected>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
				<option>13</option>
				<option>14</option>
				<option>15</option>
				<option>16</option>
				<option>17</option>
				<option>18</option>
				<option>19</option>
				<option>20</option>
				<option>21</option>
				<option>22</option>
				<option>23</option>
				<option>24</option>
				<option>25</option>
				<option>26</option>
				<option>27</option>
				<option>28</option>
				<option>29</option>
				<option>30</option>
				<option>31</option>
			</select>,

			<select size="1" name="startyear">
				<?php
				$thisYear = date("Y");
				/* output all the years from 1990 to this year */
					for($i = 1990; $i <= $thisYear; $i++) {
						?>
							<option value="<?php echo $i; ?>"><?php echo $i;?></option>
						<?php
					}
				?>
			</select>					        
