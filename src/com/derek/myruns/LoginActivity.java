package com.derek.myruns;

import android.os.Bundle;
import android.app.Activity;
import android.graphics.Color;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class LoginActivity extends Activity {
	
	public final static String EXTRA_KEY = "com.derek.myruns.userextra";
	
	Button btnLogin_;
	TextView lblStats_, lblError_;
	EditText txtUN_, txtPW_;
	User myUser_;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		
		btnLogin_ = (Button) findViewById(R.id.btnLogin);
		lblStats_ = (TextView) findViewById(R.id.lblStats);
		lblError_ = (TextView) findViewById(R.id.lblError);
		txtUN_ = (EditText) findViewById(R.id.txtUN);
		txtPW_ = (EditText) findViewById(R.id.txtPW);
		myUser_ = new User();
		
		
		btnLogin_.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				// Check the fields
				String username = txtUN_.getText().toString();
				String password = txtPW_.getText().toString();
				
				if (username.matches("") || password.matches("")) {
					lblError_.setText("Error: Must provide username and password.");
					lblError_.setTextColor(Color.RED);
				} else {
					final TryLogin login = new TryLogin(lblError_, myUser_, LoginActivity.this);
					login.execute(username, password);
				}
				
			}
		});
		
		final getSiteStats statFetch = new getSiteStats(lblStats_);
		statFetch.execute("Unused");
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.login, menu);
		return true;
	}

}
