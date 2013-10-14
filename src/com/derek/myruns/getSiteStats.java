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
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.annotation.TargetApi;
import android.os.AsyncTask;
import android.os.Build;
import android.widget.TextView;

@TargetApi(Build.VERSION_CODES.CUPCAKE)
public class getSiteStats extends AsyncTask<String, Void, String> {

	TextView stats_;
	
	getSiteStats(TextView stat) {
		stats_ = stat;
	}
	
	@Override
	protected String doInBackground(String... params) {
		HttpClient client = new DefaultHttpClient();
		
		try {
			HttpResponse response = client.execute(new HttpGet("http://www.myRuns.freeiz.com/androidStats.php"));
			
			BufferedReader reader = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
			
			StringBuilder sb = new StringBuilder();
			String line = null;
			while ((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}
			line = sb.toString();
			String stats = null;
			
			stats ="Total Users: " + (String) line.subSequence(line.indexOf("<count>")+7, line.indexOf("</count>")) + "\n";
			stats += "Weekly Miles: " + (String) line.subSequence(line.indexOf("<weekly>") + 8, line.indexOf("</weekly>")) + "\n";
			stats += "Total Miles: " + (String) line.subSequence(line.indexOf("<total>") + 7, line.indexOf("</total>"));
			return stats;
			
		} catch (UnsupportedEncodingException e) {
			// Do nothing
		} catch (ClientProtocolException e) {
			// Do nothing
		} catch (IOException e) {
			// Do nothing
		}
		
		
		return "Success";
	}
	
	protected void onPostExecute(String str) {
		stats_.setText(str);
	}

}
