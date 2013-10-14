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

import android.annotation.TargetApi;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.widget.TextView;
import android.view.View;

@TargetApi(Build.VERSION_CODES.CUPCAKE)
public class TryLogin extends AsyncTask<String, Void, String>{

	TextView error_;
	User theUser_;
	LoginActivity sender_;
	
	TryLogin(TextView err, User usr, LoginActivity sender) {
		error_ = err;
		theUser_ = usr;
		sender_ = sender;
	}
	
	@Override
	protected String doInBackground(String... params) {
		HttpClient client = new DefaultHttpClient();
		HttpPost post = new HttpPost("http://www.myRuns.freeiz.com/androidLogin.php");
		
		List<NameValuePair> prms = new ArrayList<NameValuePair>(2);
		prms.add(new BasicNameValuePair("fromAndroid", "1")); 		// Tells server we are from android
		prms.add(new BasicNameValuePair("un", params[0]));			// Username
		prms.add(new BasicNameValuePair("pw", params[1]));			// Password
			
		try {
			post.setEntity(new UrlEncodedFormEntity(prms));		// Encoded the parameters
			
			HttpResponse response = client.execute(post);
			BufferedReader reader = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
			
			StringBuilder sb = new StringBuilder();
			String line = null;
			while ((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}
			
			line = (String) sb.toString().subSequence(sb.toString().indexOf("<error>") + 7, sb.toString().indexOf("</error>"));
			
			if (line.matches("0")) { // No error
				theUser_.setUserName(params[0]);
				line = (String) sb.toString().subSequence(sb.toString().indexOf("<uid>") + 5, sb.toString().indexOf("</uid>"));
				theUser_.setUID(Long.parseLong(line, 10));	// Get the uid from the string (the 10 is the number's base)
				line = (String) sb.toString().subSequence(sb.toString().indexOf("<unit>") + 6, sb.toString().indexOf("</unit>"));
				theUser_.setUnit(Integer.parseInt(line, 10)); // Get the unit from the string
				line = (String) sb.toString().subSequence(sb.toString().indexOf("<teamID>") + 8, sb.toString().indexOf("</teamID>"));
				theUser_.setTeamID(Long.parseLong(line, 10));
				line = (String) sb.toString().subSequence(sb.toString().indexOf("<teamName>") + 10, sb.toString().indexOf("</teamName>"));
				theUser_.setTeamName(line);
				return "0";
			}
					
			return line;	// Returns the error code
			
		} catch (UnsupportedEncodingException e) {
			// Do nothing
		} catch (ClientProtocolException e) {
			// Do nothing
		} catch (IOException e) {
			// Do nothing
		}
		
		
		
		return null;
	}
	
	protected void onPostExecute(String str) {
		int error = Integer.parseInt(str, 10);
		
		
		if (error == 0) {
			error_.setText("Sucess!");
			Intent intent = new Intent(sender_, AddRun.class);
			intent.putExtra(LoginActivity.EXTRA_KEY, theUser_.toString());
			sender_.startActivity(intent);
		} else if (error == 1) {
			error_.setText("Error: Could not connect to the database!");
		} else if (error == 2) {
			error_.setText("Error: Username or password is incorrect.");
		} else {
			error_.setText("Unknown Error");
		}
		
		//error_.setText(str);
	}
	
}
