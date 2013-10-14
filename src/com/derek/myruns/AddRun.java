package com.derek.myruns;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

public class AddRun extends Activity {
	
	private Button btnAdd_;
	private TextView txtView_, txtErr_;
	private User user_;
	private Spinner month_, unit_;
	private EditText time_, distance_, day_, year_;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_add_run);
		btnAdd_ = (Button) findViewById(R.id.btnAdd);
		txtView_= (TextView) findViewById(R.id.textView1);
		txtErr_ = (TextView) findViewById(R.id.txtErr);
		month_ = (Spinner) findViewById(R.id.spinMonth);
		unit_ = (Spinner) findViewById(R.id.spinUnit);
		time_ = (EditText) findViewById(R.id.txtRunTime);
		distance_ = (EditText) findViewById(R.id.txtDistance);
		day_ = (EditText) findViewById(R.id.txtday);
		year_ = (EditText) findViewById(R.id.txtYear);
		
		
		Intent intent = getIntent();
		String userString = intent.getStringExtra(LoginActivity.EXTRA_KEY);
		
		user_ = new User(userString);
		txtView_.setText("Welcome, " + user_.getUserName());
		
		btnAdd_.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				String uid = String.valueOf(user_.getUID());
				String distance = distance_.getText().toString();
				String time = time_.getText().toString();
				String month = month_.getSelectedItem().toString();
				String day = day_.getText().toString();
				String year = year_.getText().toString();
				String unit = null;
				if (unit_.getSelectedItem().toString().matches("mi")) {
					unit = "1.609";
				} else {
					unit = "1";
				}
				
				// Validate the data a little
				if (distance.matches("") || time.matches("") || day.matches("") || year.matches("")) {
					// Form is not complete
					txtErr_.setText("Error: Form not complete.");
				} else {
					// Convert month
					if (month.matches("JAN")) {
						month = "01";
					} else if (month.matches("FEB")) {
						month = "02";
					} else if (month.matches("MAR")) {
						month = "03";
					} else if (month.matches("APR")) {
						month = "04";
					} else if (month.matches("MAY")) {
						month = "05";
					} else if (month.matches("JUN")) {
						month = "06";
					} else if (month.matches("JUL")) {
						month = "07";
					} else if (month.matches("AUG")) {
						month = "08";
					} else if (month.matches("SEP")) {
						month = "09";
					} else if (month.matches("OCT")) {
						month = "10";
					} else if (month.matches("NOV")) {
						month = "11";
					} else if (month.matches("DEC")) {
						month = "12";
					} else {
						// How could this happen??
						month = "01"; // Guess we should go with JAN
					}
					if (Integer.parseInt(day) < 10) {
						day = "0" + day;	// Add a leading zero if 1 digit
					}
					
					final AddRunAsync runAdder = new AddRunAsync(AddRun.this);
					runAdder.execute(uid, distance, time, month, day, year, unit);
					
					txtView_.setText("");
					time_.setText("");
					distance_.setText("");
					day_.setText("");
					
				}
			}
			
		});
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.add_run, menu);
		return true;
	}

}
